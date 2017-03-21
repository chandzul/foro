<?php

class ExampleTest extends FeatureTestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_basic_example()
    {
        $name = 'Duilio Palacios';
        $email = 'info@styde.ent';

        $user = factory(\App\User::class)->create([
            'name' => $name,
            'email' => $email,
        ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see($name)
            ->see($email);
    }
}
