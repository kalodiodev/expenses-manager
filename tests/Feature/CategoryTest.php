<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

abstract class CategoryTest extends IntegrationTestCase
{
    abstract protected function getCategoryClass();

    abstract protected function route();

    /**
     * Category raw data
     *
     * @param array $overrides
     * @return array|mixed
     */
    protected function categoryRaw($overrides = [])
    {
        return factory($this->getCategoryClass())->raw($overrides);
    }

    /**
     * Json post category
     *
     * @param $data
     * @return \Illuminate\Testing\TestResponse
     */
    protected function post(array $data)
    {
        return $this->postJson($this->route(), $data);
    }
}
