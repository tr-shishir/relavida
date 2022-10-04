(function( $ ){
    $.fn.scrollImage = function(){

        var imageScrollGetHeight = function( $this ){
          var imageh = $this.find( 'img' ).height(),
              screenh = $this.height();
          return parseInt( screenh - imageh );
        };

        var onHover = function(){

            // Don't scroll the image if image's height is smaller that screen's height
            if( imageScrollGetHeight( $( this ) ) > 0 )
                return;

            $ele = $( this ).find( 'img' );
            $ele.stop();

            var duration = $( this ).attr( 'data-duration' );

            if( ! duration ){
                duration = 5000;
            }

            $ele.animate({
                bottom: 0
            },parseInt( duration ) );
        };

        var onRelease = function(){

            $ele.stop();
            $ele.animate({
                bottom: imageScrollGetHeight( $( this ) )
            },500);
        };

        var setImagePosition = function( $this ){
            $this.find( 'img' ).css({
                bottom: imageScrollGetHeight( $this )
             });
        }

        this.hover( onHover, onRelease );

        var that = this;

        $( window ).resize( function(){

            that.each( function(){
                setImagePosition( $( this ) );
            });
        });

        return this.each(function() {
            setImagePosition( $( this ) );
           
        });
    };
})( jQuery );

