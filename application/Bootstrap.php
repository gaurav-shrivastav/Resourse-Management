<?php
require_once APPLICATION_PATH . '\..\vendor\doctrine\common\lib\Doctrine\Common\ClassLoader.php';

use Doctrine\Common\ClassLoader;
use  Doctrine\ORM\Configuration as DoctrineConfiguration;
use   Doctrine\Common\EventManager as DoctrineEventManager;
use   Doctrine\ORM\EntityManager as DoctrineEntityManager;
use   Doctrine\Common\Cache\ApcCache as DoctrineApcCache;
use   Doctrine\Common\Cache\ArrayCache as DoctrineArrayCache;
	
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
 protected function _initAppAutoload()
   {
       $autoloader = new Zend_Application_Module_Autoloader(array('namespace'=>'', 'basePath'=>dirname(__FILE__)));
       $loader = Zend_Loader_Autoloader::getInstance();
       $loader->suppressNotFoundWarnings(true);
       return $autoloader;
   } 
    public function _initClassLoaders()
    {
        $loader = new ClassLoader('Doctrine\ORM');
        $loader->register();
        $loader = new ClassLoader('Doctrine\Common');
        $loader->register();
        $loader = new ClassLoader('Doctrine\DBAL');
        $loader->register();
        $loader = new ClassLoader('Symfony', 'Doctrine');
        $loader->register();
        $loader = new ClassLoader('Entity', APPLICATION_PATH . '/models');
        $loader->register();
		$classLoader = new \Doctrine\Common\ClassLoader('Entities', APPLICATION_PATH );
		$classLoader->register();
    }
   public function _initDoctrineEntityManager()
    {
        $this->bootstrap(array('classLoaders', 'doctrineCache'));
        $zendConfig = $this->getOptions();
        // parameters required for connecting to the database. 
        // the required attributes are driver, host, user, password and dbname
        $connectionParameters = $zendConfig['doctrine']['connectionParameters'];
        // now initialize the configuration object
        $configuration = new DoctrineConfiguration();
        // the metadata cache is used to avoid parsing all mapping information every time
        // the framework is initialized.
        $configuration->setMetadataCacheImpl($this->getResource('doctrineCache'));
        // for performance reasons, it is also recommended to use a result cache
        $configuration->setResultCacheImpl($this->getResource('doctrineCache'));
        // if you set this option to true, Doctrine 2 will generate proxy classes for your entities
        // on the fly. This has of course impact on the performance and should therefore be disabled
        // in the production environment
        $configuration->setAutoGenerateProxyClasses($zendConfig['doctrine']['autoGenerateProxyClasses']);
        // the directory, where your proxy classes live
        $configuration->setProxyDir($zendConfig['doctrine']['proxyPath']);
        // the proxy classes' namespace
        $configuration->setProxyNamespace($zendConfig['doctrine']['proxyNamespace']);
        // the next option tells doctrine which description language we want to use for the mapping 
        // information
        $configuration->setMetadataDriverImpl(
            $configuration->newDefaultAnnotationDriver(
                 $zendConfig['doctrine']['entityPath']));
        // next, we create an event manager
        $eventManager = new DoctrineEventManager();
        // now we have everything required to initialize the entity manager
        $entityManager = DoctrineEntityManager::create($connectionParameters, $configuration, $eventManager);
        Zend_Registry::set('em', $entityManager);
        return $entityManager;
    }
    /**
     * @return Doctrine\Common\CacheProvider
     */
  public function _initDoctrineCache()
    {
        $cache = null;
        if (APPLICATION_ENV === 'development') {
            $cache = new DoctrineArrayCache();
        } else {
            $cache = new DoctrineArrayCache();
        }
        return $cache;
	}
	protected function _initAutoload()
    {
        // Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => '',
            'resourceTypes' => array(
                'model' => array(
                    'path' => 'models/',
                    'namespace' => 'Model_'
                )
            ),
        ));
        // Return it so that it can be stored by the bootstrap
		$moduleLoader = new Zend_Application_Module_Autoloader(array('namespace'=>'', 'basePath'=>APPLICATION_PATH));
        return $autoLoader;
    }
}
