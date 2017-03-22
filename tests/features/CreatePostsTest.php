<?php

class CreatePostsTest extends FeatureTestCase
{
    public function test_a_user_create_a_post()
    {
        // Having(teniendo esta informacion) -> Pregunta
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        $this->actingAs($user = $this->defaultUser());

        // When(Cuando el usuario visita la ruta) -> Lo que sucede
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        // Then(Entonces pasa algo) -> Resultado
        $this->seeInDatabase('posts', [
            'title' =>$title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        // el usuario es redireccionado al detalle del post despues de crearla
        //$this->seeInElement('h1', $title); // buscamos en una vista de blade
        $this->see($title); // buscamos lo que nos retorna la funcion store
    }

    public function test_a_guest_user_tries_to_create_a_post()
    {
        // Having(teniendo esta informacion) -> Pregunta
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        // When(Cuando el usuario visita la ruta) -> Lo que sucede
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        // Then(Entonces pasa algo) -> Resultado
        $this->seeInDatabase('posts', [
            'title' =>$title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        // el usuario es redireccionado al detalle del post despues de crearla
        //$this->seeInElement('h1', $title); // buscamos en una vista de blade
        $this->see($title); // buscamos lo que nos retorna la funcion store
    }

    public function test_creating_a_post_requires_authentication(){
        // When
        $this->visit(route('posts.create'));

        // Then
        $this->seePageIs(route('login'));

        //mensaje de alerta
        //$this->see('me manda al login por no estar logueado');
    }
}