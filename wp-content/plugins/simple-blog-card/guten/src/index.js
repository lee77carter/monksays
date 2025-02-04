import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import SimpleBlogCardAdmin from './components/simpleblogcardadmin';

domReady( () => {
    const root = createRoot(
        document.getElementById( 'simple-blog-card-settings' )
    );

    root.render( <SimpleBlogCardAdmin /> );
} );
