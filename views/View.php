<?php

namespace Views;

use App\Requests\Request;
class View
{
    private $data = array();

    private $render = FALSE;

    public function __construct($template, $variables)
    {
        try {
            $file = 'views/'.strtolower($template).'.php';

            if (file_exists($file)) {
                $this->render = $file;

                foreach($variables as $variable => $value) {
                    $this->data[$variable] = $value;
                }

                $request = new Request();
                $page = isset($request->page) ? (int)$request->page : 1;
                $next_page = $page + 1;
                $previous_page = $page == 1 ? 1 : $page - 1;
                
                $params = $request->query_params;
                $params['page'] = $next_page;
                $next_page_link = "http://$_SERVER[HTTP_HOST]".strtok($_SERVER['REQUEST_URI'], '?')."?".http_build_query($params);
                $params['page'] = $previous_page;
                $previous_page_link = "http://$_SERVER[HTTP_HOST]".strtok($_SERVER['REQUEST_URI'], '?')."?".http_build_query($params);
                $this->data['current_page'] = $page;
                $this->data['next_page_link'] = $next_page_link;
                $this->data['previous_page_link'] = $previous_page_link;
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);
    }
}
?>