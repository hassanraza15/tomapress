<?php

/**
*
*/
class CubePortfolioFrontend
{

    function __construct($data, $id)
    {

        // generate html to return to shortcode
        $this->html = $this->generateHTML($data);

        $this->options = $data[0]['options'];

        $this->style = "<style type='text/css'>" . implode('', json_decode($data[0]['customcss'], true)) . "</style>";

        $this->googleFonts = json_decode($data[0]['googlefonts']);

        $this->script = '<script type="text/javascript">jQuery.fn.cubeportfolio.initCBP(' . $id . ', ' . $data[0]['options'] . ');' .  '</script>';

    }


    public function generateHTML($data)
    {
        $items = '';
        foreach ($data as $key => $value) {
            $items .= $data[$key]['items'];
        }

        $data[0]['template'] = str_replace('{{filtersContent}}', $data[0]['filtershtml'], $data[0]['template']);
        $data[0]['template'] = str_replace('{{gridContent}}', $items, $data[0]['template']);
        $data[0]['template'] = str_replace('{{loadMoreContent}}', $data[0]['loadMorehtml'], $data[0]['template']);

        return $data[0]['template'];
    }

}

