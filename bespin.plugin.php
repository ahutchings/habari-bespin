<?php

class Bespin extends Plugin
{
    /**
     * Adds Bespin JavaScript & CSS to the publish page.
     */
    public function action_admin_header( $theme )
    {
        if ( $theme->page === 'publish' ) {
            Stack::add( 'admin_stylesheet', array($this->get_url() . '/BespinEmbedded/BespinEmbedded.css', 'screen') );
            Stack::add( 'admin_header_javascript', $this->get_url() . '/BespinEmbedded/BespinEmbedded.js', 'bespin' );

            $internal_css = <<<CSS
            #content {
                height:400px;
                width:100%;
                margin:0 0 0 -6px;
                padding:1px 6px 10px 1px;
                -moz-border-radius:3px 3px 3px 3px;
            }
CSS;

            Stack::add( 'admin_stylesheet', array($internal_css, 'screen') );
        }
    }

    /**
     * Instantiates the Bespin editor.
     */
    public function action_admin_footer( $theme )
    {
        if ( $theme->page === 'publish' ) {
            echo <<<BESPIN
            <script type="text/javascript">
            $(document).ready(function() {
                // convert content textarea to div
                // @see https://bugzilla.mozilla.org/show_bug.cgi?id=535819
                $("#content").replaceWith('<div id="content" class="styledformelement"/>');

                var node = document.getElementById("content");
                var bespin = tiki.require("embedded").useBespin(node);
            });
            </script>
BESPIN;
        }
    }
}

?>
