<?php
namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

use Cake\Event\EventListenerInterface;

class TokenAuthenticate implements EventListenerInterface
{

    use \Cake\Log\LogTrait;

    protected $_defaultConfig = [
        'fields' => []
    ];

    public function implementedEvents() {
        return [];
    }

    public function getBearerToken(ServerRequest $request)
    {
        if (preg_match('/^Bearer\s(\S+)$/', $request->getHeaderLine('Authorization'), $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getUser(ServerRequest $request)
    {
        $UserIdentities = TableRegistry::get("UserIdentities");

        $token = $this->getBearerToken($request);
        if( !$token ) {
            return false;
        }
        
        $realm = implode('/', [$request->host(), 'api']);

        $this->log('Authenticating bearer token `' . $token .'` in realm ' . $realm, 'info');

        $user_identity = $UserIdentities->find('all', [
            'conditions' => [
                'protocol' => 'bearer',
                'realm' => $realm,
                'identifier' => $token,
            ],
            'contain' => ['Users'],
        ])->first();

        if (!$user_identity) {
            return false;
        }

        $this->log(__("{0}/{1} request {2} authenticated via Bearer token: {3} in realm {4} from IP Address {5}", [
            $user_identity->user->user_id,
            $user_identity->user->username,
            Router::url($request->getAttribute('here'), true),
            $user_identity->identifier,
            $realm,
            $_SERVER['REMOTE_ADDR']
        ]), 'info');

        return $user_identity->user->toArray();
    }

    public function authenticate(ServerRequest $request, Response $response)
    {
        return $this->getUser($request);
    }

    public function unauthenticated(ServerRequest $request, Response $response)
    {
        throw new \Cake\Http\Exception\UnauthorizedException("Invalid or unspecified Authorize header. Please refer to API Documentation for further reference.");
    }
}
