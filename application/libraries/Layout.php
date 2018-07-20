<?php  
if (!defined('BASEPATH')){
	exit('No direct script access allowed'); 
}

class Layout{ 
    
    private $obj; 
    private $layout; 
    
    /**
     * @description 构造
     * @param type $layout
     */
    public function Layout($layout = "common/layout"){ 
        $this->obj = &get_instance(); 
        $this->layout = $layout; 
    } 
  
    /**
     * @description 设置layout路径
     * @param type $layout
     */
    public function setLayout($layout){ 
      $this->layout = $layout; 
    } 
    
    /**
     * @description 显示模板
     * @param type $view    content的模板路径
     * @param array $data   需要渲染的变量数组
     * @param type $return  是否取得模板的内容, 否, 直接渲染模板
     * @return type
     */
    public function view($view, $data = null, $return = false){ 
        $data['content_for_layout'] = $this->obj->load->view($view, $data, true); 
        
        if($return){ 
            $output = $this->obj->load->view($this->layout, $data, true); 
            return $output; 
        }else{ 
            $this->obj->load->view($this->layout, $data, false); 
        }
    }

}
