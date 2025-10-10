/**
 * Theme Customizer enhancements for a better user experience.
 */

( function( $ ) {
    // Hero Title
    wp.customize( 'hero_title', function( value ) {
        value.bind( function( newval ) {
            $( '.hero-main-title' ).html( newval );
        } );
    } );

    // Hero Subtitle
    wp.customize( 'hero_subtitle', function( value ) {
        value.bind( function( newval ) {
            $( '.hero-main-subtitle' ).text( newval );
        } );
    } );

    // About Intro Title
    wp.customize( 'about_intro_title', function( value ) {
        value.bind( function( newval ) {
            $( '.wix-about-intro .section-title' ).html( newval );
        } );
    } );

    // About Intro Subtitle
    wp.customize( 'about_intro_subtitle', function( value ) {
        value.bind( function( newval ) {
            $( '.wix-about-intro .section-subtitle' ).text( newval );
        } );
    } );

    // About Intro Text
    wp.customize( 'about_intro_text', function( value ) {
        value.bind( function( newval ) {
            $( '.wix-about-intro .intro-text' ).text( newval );
        } );
    } );

    // Services Title
    wp.customize( 'services_title', function( value ) {
        value.bind( function( newval ) {
            $( '.wix-services-section h2' ).text( newval );
        } );
    } );

    // Services Description
    wp.customize( 'services_description', function( value ) {
        value.bind( function( newval ) {
            $( '.wix-services-section .section-intro' ).text( newval );
        } );
    } );

    // Individual Services
    for ( var i = 1; i <= 3; i++ ) {
        ( function( index ) {
            wp.customize( 'service_' + index + '_title', function( value ) {
                value.bind( function( newval ) {
                    $( '.service-card:nth-child(' + index + ') .service-title' ).text( newval );
                } );
            } );

            wp.customize( 'service_' + index + '_description', function( value ) {
                value.bind( function( newval ) {
                    $( '.service-card:nth-child(' + index + ') .service-desc' ).text( newval );
                } );
            } );
        } )( i );
    }

    // Stats
    for ( var i = 1; i <= 4; i++ ) {
        ( function( index ) {
            wp.customize( 'stat_' + index + '_number', function( value ) {
                value.bind( function( newval ) {
                    $( '.stat-item:nth-child(' + index + ') .stat-number' ).text( newval );
                } );
            } );

            wp.customize( 'stat_' + index + '_label', function( value ) {
                value.bind( function( newval ) {
                    $( '.stat-item:nth-child(' + index + ') .stat-label' ).text( newval );
                } );
            } );
        } )( i );
    }

    // Gallery
    wp.customize( 'gallery_title', function( value ) {
        value.bind( function( newval ) {
            $( '.gallery-hero h1' ).text( newval );
        } );
    } );

    wp.customize( 'gallery_description', function( value ) {
        value.bind( function( newval ) {
            $( '.gallery-hero p' ).text( newval );
        } );
    } );

    // Contact
    wp.customize( 'contact_title', function( value ) {
        value.bind( function( newval ) {
            $( '.contact-hero h1' ).text( newval );
        } );
    } );

    wp.customize( 'contact_subtitle', function( value ) {
        value.bind( function( newval ) {
            $( '.contact-hero p' ).text( newval );
        } );
    } );

} )( jQuery );
