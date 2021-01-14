<?php

require_once __DIR__.'/IFestiEngine.php';

/**
 * @package FestiWP
 * @version 2.2
 */
abstract class FestiPlugin extends FestiObject implements IFestiEngine
{
    protected $_wpUrl;
    protected $_wpPluginsUrl;
    
    protected $_pluginDirName;
    protected $_pluginMainFile;
    
    protected $_pluginPath;
    protected $_pluginUrl;
    
    protected $_pluginCachePath;
    protected $_pluginCacheUrl;
    
    protected $_pluginStaticPath;
    protected $_pluginStaticUrl;
        
    protected $_pluginCssPath;
    protected $_pluginCssUrl;
    
    protected $_pluginImagesPath;
    protected $_pluginImagesUrl;
    
    protected $_pluginJsPath;
    protected $_pluginJsUrl;
    
    protected $_pluginTemplatePath;
    protected $_pluginTemplateUrl;
    
    protected $_pluginLanguagesPath;
    protected $_pluginLanguagesUrl;

    protected $languageDomain = '';
    protected $optionsPrefix  = '';
    
    protected $fileSystem = '';

    /**
     * The instance of current CMS or eCommerce platform.
     *
     * @var $engineFacade
     */
    protected $engineFacade = null;
    
    public function __construct($pluginMainFile)
    {
        $this->engineFacade = EngineFacade::getInstance();
        
        $this->_wpUrl = get_site_url();
        $this->_wpUrl = $this->makeUniversalLink($this->_wpUrl);
        
        $this->_wpPluginsUrl = plugins_url('/');
        $this->_wpPluginsUrl = $this->makeUniversalLink($this->_wpPluginsUrl);
        
        $this->_pluginDirName = plugin_basename(dirname($pluginMainFile)).'/';
        
        $this->_pluginMainFile = $pluginMainFile;
        
        $this->_pluginPath = plugin_dir_path($pluginMainFile);
        $this->_pluginUrl = plugins_url('/', $pluginMainFile);
        $this->_pluginUrl = $this->makeUniversalLink($this->_pluginUrl);
        
        $this->_pluginCachePath = $this->_pluginPath.'cache/';
        $this->_pluginCacheUrl = $this->_pluginUrl.'cache/';
        
        $this->_pluginStaticPath = $this->_pluginPath.'static/';
        $this->_pluginStaticUrl = $this->_pluginUrl.'static/';
        
        $this->_pluginCssPath = $this->_pluginStaticPath.'styles/';
        $this->_pluginCssUrl = $this->_pluginStaticUrl.'styles/';
        
        $this->_pluginImagesPath = $this->_pluginStaticPath.'images/';
        $this->_pluginImagesUrl = $this->_pluginStaticUrl.'images/';
        
        $this->_pluginJsPath = $this->_pluginStaticPath.'js/';
        $this->_pluginJsUrl = $this->_pluginStaticUrl.'js/';
        
        $this->_pluginTemplatePath = $this->_pluginPath.'templates/';
        $this->_pluginTemplateUrl = $this->_pluginUrl.'templates/';
        
        $this->_pluginLanguagesPath = $this->_pluginDirName.'languages/';

        $this->onInit();
    } // end __construct
    
    public function makeUniversalLink($url = '')
    {
        $protocols = array(
            'http:',
            'https:'
        );
        
        foreach ($protocols as $protocol) {
            $url = str_replace($protocol, '', $url);
        }
        
        return $url;
    } // end makeUniversalLink
    
    private function _isAjaxRequestFromFrontend()
    {
        $scriptFileName = '';
        if (!empty($_SERVER['SCRIPT_FILENAME'])) {
            $scriptFileName = $_SERVER['SCRIPT_FILENAME'];
        }

        $url = $this->_getReferredUrl();

        $adminUrl = admin_url();

        if ($url == '/wp-admin/admin-ajax.php') {
            $adminUrl = '/wp-admin/';
        }

        return strpos($url, $adminUrl) === false &&
               basename($scriptFileName) === 'admin-ajax.php';        
    } // end _isAjaxRequestFromFrontend
    
    private function _isBackend() 
    {        
        return defined('WP_BLOG_ADMIN') ||
               defined('WP_TESTS_TABLE_PREFIX') ||
               (defined('DOING_AJAX') && DOING_AJAX) &&
               !$this->_isAjaxRequestFromFrontend();
    } // end _isBackend

    protected function onInit()
    {
        $facade = WordpressFacade::getInstance();

        $facade->registerActivationHook(
            array(&$this, 'onInstall'),
            $this->_pluginMainFile
        );

        $facade->registerDeactivationHook(
            array(&$this, 'onUninstall'),
            $this->_pluginMainFile
        );
        
        if ($this->_isBackend()) {
            $this->onBackendInit();
        } else {
            $this->onFrontendInit();
        }
    } // end onInit
    
    protected function onBackendInit()
    {
    } // end onBackendInit
    
    protected function onFrontendInit()
    {
    } // end onFrontendInit
    
    public function onInstall()
    {
    } // end onInstall
    
    public function onUninstall()
    {
    } // end onUninstall
    
    public function getLanguageDomain()
    {
        return $this->languageDomain;
    } // end getLanguageDomain
    
    /**
     * Use for correct support multilanguages. Example:
     * 
     * <code>
     * $this->getLang('Hello');
     * $this->getLang('Hello, %s', $userName);
     * </code>
     * 
     * @param ...$args
     * @return boolean|string
     */
    public function getLang()
    {
        $args = func_get_args();
        if (!isset($args[0])) {
            return false;
        }
        
        $word = __($args[0], $this->getLanguageDomain());
        if (!$word) {
            $word = $args[0];
        }
        
        $params = array_slice($args, 1);
        if ($params) {
            $word = vsprintf($word, $params);
        }
        
        return $word;
    } // end getLang
    
    public function getPluginPath()
    {
        return $this->_pluginPath;
    } // end getPluginPath
    
    public function getPluginCachePath($fileName)
    {
        return $this->_pluginCachePath.$fileName.'.php';
    } // end getPluginCachePath
    
    public function getPluginStaticPath($fileName)
    {
        return $this->_pluginStaticPath.$fileName;
    } // end pluginStaticPath
    
    public function getPluginCssPath($fileName)
    {
        return $this->_pluginCssPath.$fileName;
    } // end pluginCssPath
    
    public function getPluginImagesPath($fileName)
    {
        return $this->_pluginImagesPath.$fileName;
    } // end pluginImagesPath
    
    public function getPluginJsPath($fileName)
    {
        return $this->_pluginJsPath.$fileName;
    } // end pluginJsPath
    
    public function getPluginTemplatePath($fileName)
    {
        return $this->_pluginTemplatePath.$fileName;
    } // end getPluginTemplatePath
    
    public function getPluginLanguagesPath()
    {
        return $this->_pluginLanguagesPath;
    } // end getPluginLanguagesPath

    public function getPluginUrl()
    {
        return $this->_pluginUrl;
    } // end getPluginUrl
    
    public function getPluginCacheUrl()
    {
        return $this->_pluginCacheUrl;
    } // end getPluginCacheUrl
    
    public function getPluginStaticUrl()
    {
        return $this->_pluginStaticUrl;
    } // end getPluginStaticUrl

    public function getPluginCssUrl($fileName, $customUrl = false)
    {
        if ($customUrl) {
            return $customUrl.$fileName;
        }

        return $this->_pluginCssUrl.$fileName;
    } // end getPluginCssUrl
    
    public function getPluginImagesUrl($fileName)
    {
        return $this->_pluginImagesUrl.$fileName;
    } // end getPluginImagesUrl

    public function getPluginJsUrl($fileName, $customUrl = false)
    {
        if ($customUrl) {
            return $customUrl.$fileName;
        }

        return $this->_pluginJsUrl.$fileName;
    } // end getPluginJsUrl

    public function getPluginTemplateUrl($fileName)
    {
        return $this->_pluginTemplateUrl.$fileName;
    } // end getPluginTemplateUrl
    
    public function isPluginActive($pluginMainFilePath)
    {
        if (is_multisite()) {
           $activePlugins = get_site_option('active_sitewide_plugins');
           $result =  array_key_exists($pluginMainFilePath, $activePlugins);
           if ($result) {
               return true;
           }
        }
        
        $activePlugins = get_option('active_plugins');
        return in_array($pluginMainFilePath, $activePlugins);
    } // end isPluginActive
    
    public function addActionListener(
        $hook, $method, $priority = 10, $acceptedArgs = 1
    )
    {
        if (!is_array($method)) {
            $method = array(&$this, $method);
        }
        
        add_action($hook, $method, $priority, $acceptedArgs);
    } // end addActionListener
    
    public function addFilterListener(
        $hook, $method, $priority = 10, $acceptedArgs = 1
    )
    {
        if (!is_array($method)) {
            $method = array(&$this, $method);
        }
        
        add_filter($hook, $method, $priority, $acceptedArgs);
    } // end addFilterListener
    
    public function addShortCodeListener($tag, $method)
    {
        add_shortcode(
            $tag,
            array(&$this, $method)
        );
    } // end addShortCodeListener
    
    public function getOptions($optionName)
    {
        $options = $this->getCache($optionName);

        if (!$options) {
           $options = get_option($this->optionsPrefix.$optionName); 
        }
        
        $options = json_decode($options, true);
   
        return $options;
    } // end getOptions
    
    public function getCache($fileName)
    {
        $file = $this->getPluginCachePath($fileName);
        
        if (!file_exists($file)) {
            return false;
        }
        
        ob_start();

        include($file);

        $content = ob_get_contents();
        
        ob_end_clean();
        
        return $content;
    } //end getCache
    
    public function updateOptions($optionName, $values = array())
    {
        $values = $this->_doChangeSingleQuotesToDouble($values);

        $value = json_encode($values);
        
        update_option($this->optionsPrefix.$optionName, $value);
        
        $result = $this->updateCacheFile($optionName, $value);

        return $result;
    } // end updateOptions
    
    private function _doChangeSingleQuotesToDouble($options = array())
    {
        foreach ($options as $key => $value) {
            if (!is_string($value)) {
                continue;
            }
            
            $result = str_replace("'", '"', $value);
            
            if ($this->isPathOption($key)) {
                $options[$key] = addslashes(realpath($result));
            } else {
                $options[$key] = stripslashes($result);
            }
        }
        
        return $options;
    } // end _doChangeSingleQuotesToDouble
    
    public function isPathOption($key)
    {
        $options = array(
            'filePath',
            'uploadFolderPath'
        );
        
        return in_array($key, $options);
    }
    
    public function updateCacheFile($fileName, $values)
    {
        if (!$this->fileSystem) {
            $this->fileSystem = $this->getFileSystemInstance();
        }
        
        if (!$this->fileSystem) {
            return false;
        }
   
        if (!$this->fileSystem->is_writable($this->_pluginCachePath)) {
            return false;
        }
        
        $content = "<?php return '".$values."';";
        
        $filePath = $this->getPluginCachePath($fileName);

        $this->fileSystem->put_contents($filePath, $content, 0777);
    } //end updateCacheFile
    
    public function &getFileSystemInstance($method = 'direct')
    {
        $wpFileSystem = false;
        
        if ($this->_hasWordpressFileSystemObjectInGlobals()) {
            $wpFileSystem = $GLOBALS['wp_filesystem'];
        }

        if (!$wpFileSystem) {
            $this->defineFileSystemMethod($method);
            WP_Filesystem();
            $wpFileSystem = $GLOBALS['wp_filesystem'];
        }

        return $wpFileSystem;
    } // end doWriteCacheToFile
    
    protected function defineFileSystemMethod($method)
    {
        if (!defined('FS_METHOD')) {
            define('FS_METHOD', $method);
        }
    } // end defineFileSystemMethod
    
    private function _hasWordpressFileSystemObjectInGlobals()
    {
        return array_key_exists('wp_filesystem', $GLOBALS);
    } // end _hasWordpressFileSystemObjectInGlobals

    public function onEnqueueJsFileAction(
        $handle,
        $file = '',
        $deps = '',
        $version = false,
        $inFooter = false,
        $customUrl = false
    )
    {
        $src = '';

        if ($file) {
            $src = $this->getPluginJsUrl($file, $customUrl);
        }

        if ($deps) {
            $deps = array($deps);
        }

        wp_enqueue_script($handle, $src, $deps, $version, $inFooter);
    } // end  onEnqueueJsFileAction

    public function onEnqueueCssFileAction(
        $handle,
        $file = '',
        $deps = array(),
        $version = false,
        $media = 'all',
        $customUrl = false
    )
    {
        $src = '';

        if ($file) {
            $src = $this->getPluginCssUrl($file, $customUrl);
        }

        if ($deps) {
            $deps = array($deps);
        }

        wp_enqueue_style($handle, $src, $deps, $version, $media);
    } // end  onEnqueueCssFileAction
    
    public function fetch($template, $vars = array()) 
    {
        if ($vars) {
            extract($vars);
        }

        ob_start();
              
        $templatePath = $this->getPluginTemplatePath($template); 
        
        include $templatePath;

        $content = ob_get_clean();    
        
        return $content;                
    } // end fetch
    
    public function getUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        
        $args = func_get_args();
        if (!$args) {
            return $url;
        }
        
        if (!is_array($args[0])) {
            $url = $args[0];
            $args = array_slice($args, 1);
        }

        if (isset($args[0]) && is_array($args[0])) {
            
            $data = parse_url($url);
            
            if (array_key_exists('query', $data)) {
                $url = $data['path'];
                parse_str($data['query'], $params);
                            
                foreach ($args[0] as $key => $value) {
                    if ($value != '') {
                       continue;
                    }
                    
                    unset($args[0][$key]);
                    
                    if (array_key_exists($key, $params)) {
                        unset($params[$key]);
                    }
                }
        
                $args[0] = array_merge($params, $args[0]);
            }

            $seperator = preg_match("#\?#Umis", $url) ? '&' : '?';
            $url .= $seperator.http_build_query($args[0]);
        }
        
        return $url;
    } // end getUrl
    
    public function displayError($error)
    {
        $this->displayMessage($error, 'error');
    } // end displayError
    
    public function displayUpdate($text)
    {
        $this->displayMessage($text, 'updated');
    } // end displayUpdate
    
    public function displayMessage($text, $type)
    {
        $message = __(
            $text,
            $this->languageDomain
        );
        
        $template = 'message.phtml';

        $vars = array(
            'type' => $type,
            'message' => $message
        );

        echo $this->fetch($template, $vars);
    }// end displayMessage

    private function _getReferredUrl()
    {
        $url = '';
        if (!empty($_REQUEST['_wp_http_referer'])) {
            $url = wp_unslash($_REQUEST['_wp_http_referer']);
        } else if (!empty($_SERVER['HTTP_REFERER'])) {
            $url = wp_unslash($_SERVER['HTTP_REFERER']);
        }

        $url = parse_url($url);

        if (!empty($url['scheme'])) {
            $url['scheme'] .= '://';
        }

        $url = $url['scheme'].$url['host'].$url['path'];

        return $url;
    } // end _getReferredUrl
}