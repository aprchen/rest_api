<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/12/10
 * Time: 下午6:23
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Fractal\Query\QueryParsers;

/**
 * @author Olivier Andriessen olivierandriessen@gmail.com Bart Blok bart@wittig.nl
 * @source(redound/phalcon-api)
 */
use App\Component\Core\ApiPlugin;
use App\Fractal\Query\Condition;
use App\Fractal\Query\Query;
use App\Fractal\Query\Sorter;
use Phalcon\Mvc\Model\Query\Builder;

class PhqlQueryParser extends ApiPlugin
{
    const OPERATOR_IS_EQUAL = '=';
    const OPERATOR_IS_GREATER_THAN = '>';
    const OPERATOR_IS_GREATER_THAN_OR_EQUAL = '>=';
    const OPERATOR_IS_IN = 'IN';
    const OPERATOR_IS_LESS_THAN = '<';
    const OPERATOR_IS_LESS_THAN_OR_EQUAL = '<=';
    const OPERATOR_IS_LIKE = 'LIKE';
    const OPERATOR_IS_JSON_CONTAINS = 'JSON_CONTAINS';
    const OPERATOR_IS_NOT_EQUAL = '!=';

    const DEFAULT_KEY = 'value';

    /**
     * @param Query $query
     * @param $model
     * @param $primaryKey
     * @param bool $cache
     * @return Builder 创建builder
     * 创建builder
     */
    public function fromQuery(Query $query, $model,$primaryKey,$cache = false)
    {
        /** @var \Phalcon\Mvc\Model\Manager $modelsManager */
        $modelsManager = $this->di->getShared('modelsManager');

        /** @var Builder $builder */
        $builder = $modelsManager->createBuilder()->from($model);

        $this->applyQuery($builder, $query, $primaryKey);

        return $builder;
    }

    public function applyQuery(Builder $builder, Query $query, $primaryKey)
    {
        $from = $builder->getFrom();
        $fromString = is_array($from) ? array_keys($from)[0] : $from;

        if ($query->hasFields()) {
            $builder->columns($query->getFields());
        }

        if ($query->hasOffset()) {

            $builder->offset($query->getOffset());
        }

        if ($query->hasLimit()) {

            $builder->limit($query->getLimit());
        }

        if ($query->hasConditions()) {

            $conditions = $query->getConditions();

            $andConditions = [];
            $orConditions = [];

            /** @var Condition $condition */
            foreach ($conditions as $conditionIndex => $condition) {

                if($condition->getType() == Condition::TYPE_AND){
                    $andConditions[] = $condition;
                }
                else if($condition->getType() == Condition::TYPE_OR){
                    $orConditions[] = $condition;
                }
            }

            $allConditions = $orConditions + $andConditions;

            /** @var Condition $condition */
            foreach ($allConditions as $conditionIndex => $condition) {

                $operator = $this->getOperator($condition->getOperator());

                if(!$operator){
                    continue;
                }

                $parsedValues = $this->parseValues($operator, $condition->getValue());

                $format = $this->getConditionFormat($operator);
                $valuesReplacementString = $this->getValuesReplacementString($parsedValues, $conditionIndex);
                $fieldString = sprintf('[%s].[%s]', $fromString, $condition->getField());

                $conditionString = sprintf($format, $fieldString, $operator, $valuesReplacementString);

                $bindValues = $this->getBindValues($parsedValues, $conditionIndex);

                switch ($condition->getType()) {

                    case Condition::TYPE_OR:
                        $builder->orWhere($conditionString, $bindValues);
                        break;
                    case Condition::TYPE_AND:
                    default:
                        $builder->andWhere($conditionString, $bindValues);
                        break;
                }
            }
        }

        if($query->hasExcludes()){

            $builder->notInWhere($fromString . '.' . $primaryKey, $query->getExcludes());
        }

        if ($query->hasSorters()) {

            $sorters = $query->getSorters();

            /** @var Sorter $sorter */
            foreach ($sorters as $sorter) {

                switch ($sorter->getDirection()) {

                    case Sorter::DESCENDING:
                        $direction = 'DESC';
                        break;
                    case Sorter::ASCENDING:
                    default:
                        $direction = 'ASC';
                        break;
                }

                $fieldString = sprintf('[%s].[%s]', $fromString, $sorter->getField());
                $builder->orderBy($fieldString . ' ' . $direction);
            }
        }
    }

    private function getOperator($operator)
    {
        $operatorMap = $this->operatorMap();

        if (array_key_exists($operator, $operatorMap)) {
            return $operatorMap[$operator];
        }

        return null;
    }

    private function operatorMap()
    {
        return [
            Query::OPERATOR_IS_EQUAL => self::OPERATOR_IS_EQUAL,
            Query::OPERATOR_IS_GREATER_THAN => self::OPERATOR_IS_GREATER_THAN,
            Query::OPERATOR_IS_GREATER_THAN_OR_EQUAL => self::OPERATOR_IS_GREATER_THAN_OR_EQUAL,
            Query::OPERATOR_IS_IN => self::OPERATOR_IS_IN,
            Query::OPERATOR_IS_LESS_THAN => self::OPERATOR_IS_LESS_THAN,
            Query::OPERATOR_IS_LESS_THAN_OR_EQUAL => self::OPERATOR_IS_LESS_THAN_OR_EQUAL,
            Query::OPERATOR_IS_LIKE => self::OPERATOR_IS_LIKE,
            Query::OPERATOR_IS_JSON_CONTAINS => self::OPERATOR_IS_JSON_CONTAINS,
            Query::OPERATOR_IS_NOT_EQUAL => self::OPERATOR_IS_NOT_EQUAL,
        ];
    }

    private function parseValues($operator, $values)
    {
        $self = $this;

        if (is_array($values)) {

            return array_map(function ($value) use ($self, $operator) {
                return $self->parseValue($operator, $value);
            }, $values);
        }

        return $this->parseValue($operator, $values);
    }

    private function parseValue($operator, $value)
    {
        return $value;
    }

    private function getConditionFormat($operator)
    {
        $format = null;

        switch ($operator) {

            case self::OPERATOR_IS_IN:
                $format = '%s %s (%s)';
                break;
            case self::OPERATOR_IS_JSON_CONTAINS:
                $format = '%1$s %2$s (%1$s, %3$s)';
                break;
            default:
                $format = '%s %s %s';
                break;

        }

        return $format;
    }

    private function getValuesReplacementString($values, $suffix = '')
    {
        $key = self::DEFAULT_KEY . $suffix;

        if (is_array($values)) {

            $valueIndex = 0;
            $formatted = [];

            for ($valueIndex = 0; $valueIndex < count($values); $valueIndex++) {

                $formatted[] = ':' . $key . '_' . $valueIndex . ':';
            }

            return implode(', ', $formatted);
        }

        return ':' . $key . ':';
    }

    private function getBindValues($values, $suffix = '')
    {
        $key = self::DEFAULT_KEY . $suffix;

        if (is_array($values)) {

            $valueIndex = 0;
            $parsed = [];

            foreach ($values as $value) {

                $parsed[$key . '_' . $valueIndex] = $value;
                $valueIndex++;
            }

            return $parsed;
        }

        return [$key => $values];
    }

}