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
            // The directory for the project views
            $file = 'views/'.strtolower($template).'.php';

            if (file_exists($file)) {
                $this->render = $file;

                // The variables that will be required by the view to be rendered
                foreach($variables as $variable => $value) {
                    $this->data[$variable] = $value;
                }
 
                $request = new Request();
                // Set the current, next and previous pages number
                $page = isset($request->page) ? (int)$request->page : 1;
                $next_page = $page + 1;
                $previous_page = $page == 1 ? 1 : $page - 1;
                
                // Using request object get an array of current query parameters
                $params = $request->query_params;
                // Update the number of next page
                $params['page'] = $next_page;
                // Build a new query parmeter string after page number update
                $next_page_link = "http://$_SERVER[HTTP_HOST]".strtok($_SERVER['REQUEST_URI'], '?')."?".http_build_query($params);
                // Update the number of previous page
                $params['page'] = $previous_page;
                // Build a new query parmeter string after page number update
                $previous_page_link = "http://$_SERVER[HTTP_HOST]".strtok($_SERVER['REQUEST_URI'], '?')."?".http_build_query($params);

                // Define the variables that will be used for pagination
                $this->data['current_page'] = $page;
                $this->data['next_page_link'] = $next_page_link;
                $this->data['previous_page_link'] = $previous_page_link;
            } else {
                // Template not found in the views directory
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