(function() {
    document.addEventListener( 'wpcf7invalid', function( event ) {

        setTimeout(function(){
            let invalidElList = document.querySelectorAll("input.wpcf7-not-valid, textarea.wpcf7-not-valid")

            console.log("invalid elements")
            console.log(invalidElList);
            invalidElList.forEach(element => {
                element.addEventListener("click", (e) => {
                    e.target.nextElementSibling.style.display = "none";
                })
            });
         }, 250);


    }, false );



})();