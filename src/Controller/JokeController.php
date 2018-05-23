<?php

namespace App\Controller;

use App\Event\JokeSubscribedEvent;
use App\Form\SubscriptionType;
use App\Listener\JokeSubscriber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JokeController extends Controller
{
    /**
     * Joke form
     *
     * @Route("/", name="home")
     */
    public function jokeForm(Request $request)
    {
        $form = $this->createForm(SubscriptionType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get validated data, initialize event and send joke to user
            $userData = $form->getData();

            $dispatcher = new EventDispatcher();
            $jokeListener = $this->container->get(JokeSubscriber::class);

            $dispatcher->addSubscriber($jokeListener);

            $event = new JokeSubscribedEvent($userData['email'], $userData['category']);
            $dispatcher->dispatch(JokeSubscribedEvent::NAME, $event);

            return $this->redirectToRoute('user_subscribed');
        }

        return $this->render('joke_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Joke was successfully sent
     *
     * @Route("/success", name="user_subscribed")
     */
    public function userSubscribed()
    {
        return $this->render('success.html.twig');
    }
}