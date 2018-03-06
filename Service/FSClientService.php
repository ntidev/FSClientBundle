<?php

namespace NTI\FSClientBundle\Service;

use NTI\FSClientBundle\Exception\FileRegistrationException;
use NTI\FSClientBundle\Exception\TokenGenerationException;
use NTI\FSClientBundle\Model\Token;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FSClientService {

    const REGISTER_FILE_URL = "file/register";
    const GENERATE_TOKEN_URL = "token/generate";

    /** @var ContainerInterface $container */
    private $container;

    /** @var string $endpoint */
    private $endpoint;

    /** @var string $appName */
    private $appName;

    /** @var string $authKey */
    private $authKey;

    /** @var \GuzzleHttp\Client $client */
    private $client;

    /**
     * FSClientService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->endpoint = $this->container->getParameter('ntifs.endpoint');
        $this->appName = $this->container->getParameter('ntifs.app_name');
        $this->authKey = $this->container->getParameter('ntifs.auth_key');

        $this->client = new \GuzzleHttp\Client();

    }

    /**
     * @param $path
     * @return Token
     * @throws FileRegistrationException
     */
    public function registerFile($path) {

        $url = $this->endpoint . self::REGISTER_FILE_URL;

        try {
            $response = $this->client->request('POST', $url, array(
                'auth' => array($this->appName, $this->authKey),
                'json' => array(
                    'path' => $path
                ),
            ));
            $tokenContent = $response->getBody()->getContents();
            $token = $this->container->get('serializer')->deserialize($tokenContent, Token::class, 'json');
            return $token;
        } catch (\Exception $ex) {
            if($this->container->has('nti.logger')) {
                $this->container->get('nti.logger')->logException($ex);
            }
            throw new FileRegistrationException("An unknown error occurred while registering the file and getting the token.");
        }
    }

    /**
     * @param $path
     * @return Token
     * @throws TokenGenerationException
     */
    public function generateToken($path) {

        $url = $this->endpoint . self::GENERATE_TOKEN_URL;

        try {
            $response = $this->client->request('POST', $url, array(
                'auth' => array($this->appName, $this->authKey),
                'json' => array(
                    'path' => $path
                ),
            ));
            $tokenContent = $response->getBody()->getContents();
            $token = $this->container->get('serializer')->deserialize($tokenContent, Token::class, 'json');
            return $token;
        } catch (\Exception $ex) {
            if($this->container->has('nti.logger')) {
                $this->container->get('nti.logger')->logException($ex);
            }
            throw new TokenGenerationException("An unknown error occurred while registering the file and getting the token.");
        }
    }

}