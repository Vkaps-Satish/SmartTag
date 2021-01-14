<?php

class WordpressFacade
{
    private static $_instance = null;

    public static function &getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    } // end &getInstance

    public function __construct()
    {
         if (isset(self::$_instance)) {
            $message = 'Instance already defined ';
            $message .= 'use WordpressFacade::getInstance';
            throw new Exception($message);
         }
    } // end __construct

    public function getAttachmentsByPostID($postParent, $fileType)
    {
        $attachmentQuery = array(
            'numberposts' => -1,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_parent' => $postParent,
            'post_mime_type' => $fileType
        );
        
        $attachments = get_posts($attachmentQuery);
        
        return $attachments;
    } // end getAttachmentsByPostID
    
    public function getAbsolutePath($url)
    {
        return str_replace(home_url('/'), ABSPATH, $url);
    } // end getAbsolutePath
    
    public function addAttachment($idPost, $attachment, $path)
    {
        $id = wp_insert_attachment($attachment, $path, $idPost);
        
        return $id;
    } // end addAttachment
    
    public function getPluginData($pluginPath)
    {
        return get_plugin_data($pluginPath);    
    } // end getPluginData

    public static function createQueryInstance($params = array())
    {
        return new WP_Query($params);
    } // end createQueryInstance
    
    public function onRemoveAllActions($hookName)
    {
        return remove_all_actions($hookName);
    } // end onRemoveAllActions
    
    public function deleteOption($optionName)
    {
        return delete_option($optionName);
    } // end deleteOption

    public function getQueryVars($query)
    {
        return $query->query_vars;
    } // end getQueryVars

    public function getProductType($idPost)
    {
        return $this->getPostMeta($idPost, '_product_type', true);
    } // end getProductType

    public function getCurrentPostID()
    {
        return get_the_ID();
    } // end getCurrentPostID

    public function registerActivationHook(
        $callback,
        $pluginMainFilePath
    )
    {
        register_activation_hook(
            $pluginMainFilePath,
            $callback
        );
    } // end registerActivationHook

    public function registerDeactivationHook(
        $callback,
        $pluginMainFilePath
    )
    {
        register_deactivation_hook(
            $pluginMainFilePath,
            $callback
        );
    } // end registerDeactivationHook

    public function updateOption($optionName, $value, $autoload = null)
    {
        return update_option($optionName, $value, $autoload);
    } // end updateOption

    public function getOption($optionName, $default = false )
    {
        return get_option($optionName, $default);
    } // end getOption

    public function updatePostMeta(
        $idPost,
        $metaKey,
        $metaValue,
        $previousValue = ''
    )
    {
        return update_post_meta($idPost, $metaKey, $metaValue, $previousValue);
    } // end updatePostMeta

    public function getPostMeta($idPost, $metaKey = '', $single = false)
    {
        return get_post_meta($idPost, $metaKey, $single);
    } // end getPostMeta

    public function isCurrentUserCan($capability, $args = null)
    {
        return current_user_can($capability, $args);
    } // end isCurrentUserCan

    public function dispatchAction($actionName)
    {
        if (!is_array($actionName)) {
            $params = array($actionName);
        } else {
            $params = $actionName;
        }

        $args = func_get_args();

        array_shift($args);

        $params = array_merge($params, $args);

        return call_user_func_array('do_action', $params);
    } // end dispatchAction

    public function dispatchFilter($filterName, &$value)
    {
        $params = array(
            $filterName,
            $value
        );

        $args = func_get_args();

        $args = array_slice($args, 2);

        $params = array_merge($params, $args);

        $result = call_user_func_array('apply_filters', $params);

        Controller::getInstance()->fireEvent($filterName, $result);

        return $result;
    } // end dispatchFilter

    public function addActionListener(
        $hook, $method, $priority = 10, $acceptedArgs = 1
    )
    {
        add_action($hook, $method, $priority, $acceptedArgs);
    } // end addActionListener

    public function addFilterListener(
        $hook, $method, $priority = 10, $acceptedArgs = 1
    )
    {
        add_filter($hook, $method, $priority, $acceptedArgs);
    } // end addFilterListener

    protected function getIdent()
    {
        return 'wordpress';
    }

    public function setObjectTerms($idPost, $terms, $taxonomy, $append = false)
    {
        wp_set_object_terms($idPost, $terms, $taxonomy, $append);
    } // end setObjectTerms

    public function addPostMeta($idPost, $metaKey, $metaValue, $unique = false)
    {
        add_post_meta($idPost, $metaKey, $metaValue, $unique);
    } // end addPostMeta

    public function doInsertPost($postData, $error = false)
    {
        return wp_insert_post($postData, $error);
    } // end doInsertPost

    public function doUpdatePost($postData, $error = false)
    {
        return wp_update_post($postData, $error);
    } // end doUpdatePost

    public function getPostStatus($idPost = false)
    {
        return get_post_status($idPost);
    } // end getPostStatus

    public function getActiveThemeName()
    {
        $theme = wp_get_theme();

        return $theme->name;
    } // end getActiveThemeName

    public function doEnqueueScript(
        $handle,
        $source = '',
        $dependsOn = array(),
        $version = false,
        $inFooter = false
    )
    {
        wp_enqueue_script($handle, $source, $dependsOn, $version, $inFooter);
    } // end doEnqueueScript

    public function doEnqueueStyle(
        $handle,
        $source = '',
        $dependsOn = array(),
        $version = false,
        $media = 'all'
    )
    {
        wp_enqueue_style($handle, $source, $dependsOn, $version, $media);
    } // end doEnqueueStyle

    public function addUserRole($role, $displayName, $capabilities = array())
    {
        return add_role($role, $displayName, $capabilities);
    } // end addUserRole
}