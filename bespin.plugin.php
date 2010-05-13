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
                position:absolute;
                left:-10000px;
            }
            #bespin {
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
                // Bespin does not attach correctly to textareas.
                // @link https://bugzilla.mozilla.org/show_bug.cgi?id=535819
                $("#content").after('<div id="bespin" class="bespin styledformelement">'+$("#content").val()+'</div>');
            });

            window.onBespinLoad = function() {
                bespin = document.getElementById("bespin").bespin;

                bespin.addEventListener('textChange', function() {
                    $("#content").text(bespin.getValue());
                });
            };
            </script>
BESPIN;
        }
    }
}

?>
