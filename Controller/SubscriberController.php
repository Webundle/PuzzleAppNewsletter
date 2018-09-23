<?php

namespace Puzzle\App\NewsletterBundle\Controller;

use GuzzleHttp\Exception\BadResponseException;
use Puzzle\ConnectBundle\ApiEvents;
use Puzzle\ConnectBundle\Event\ApiResponseEvent;
use Puzzle\ConnectBundle\Service\PuzzleApiObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * @author AGNES Gnagne Cedric <cecenho55gmail.com>
 * 
 */
class SubscriberController extends Controller
{
    /**
     * @var array $fields
     */
    private $fields;
    
    public function __construct() {
        $this->fields = ['name', 'description'];
    }
    
	/***
	 * Create subscriber
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function subscribeAction(Request $request)
	{
	    if ($request->isMethod('POST') === true) {
	        try {
	            $postData = $request->request->all();
	            $postData = PuzzleApiObjectManager::sanitize($postData);
	            /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
	            $apiClient = $this->get('puzzle_connect.api_client');
	            $apiClient->push('post', '/newsletter/subscribers', $postData);
	            
	            if ($request->isXmlHttpRequest() === true) {
	                return new JsonResponse(true);
	            }
	            
	            $this->addFlash('success', $this->get('translator')->trans('message.post', [], 'success'));
	        }catch (BadResponseException $e) {
	            /** @var EventDispatcher $dispatcher */
	            $dispatcher = $this->get('event_dispatcher');
	            $event = $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
	            
	            if ($request->isXmlHttpRequest() === true) {
	                return $event->getResponse();
	            }
	        }
	        
	        return $this->redirectToRoute('app_homepage');
	    }
	    
	    return $this->render($this->getParameter('app_newsletter.templates')['subscriber']['subscribe']);
	}
	
	
	/**
	 * Delete a subscriber
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function unsubscribeAction(Request $request, $id) {
	    try {
	        /** @var Puzzle\ConnectBundle\Service\PuzzleAPIClient $apiClient */
    	    $apiClient = $this->get('puzzle_connect.api_client');
    	    $apiClient->push('delete', '/newsletter/subscribers/'.$id);
	        
	        if ($request->isXmlHttpRequest() === true) {
	            return new JsonResponse(['status' => true]);
	        }
	        
	        $this->addFlash('success', $this->get('translator')->trans('message.delete', [], 'success'));
	    }catch (BadResponseException $e) {
	        /** @var EventDispatcher $dispatcher */
	        $dispatcher = $this->get('event_dispatcher');
	        $event  = $dispatcher->dispatch(ApiEvents::API_BAD_RESPONSE, new ApiResponseEvent($e, $request));
	        
	        if ($request->isXmlHttpRequest()) {
	            return $event->getResponse();
	        }
	    }
	    
		return $this->redirectToRoute('app_homepage');
	}
}
