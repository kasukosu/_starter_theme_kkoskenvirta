(function() {

    function scrollTo() {

        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

    }

    let scrollBtn = document.querySelector('button#scrollToTop');
    let touchEvent = 'ontouchstart' in window ? 'touchstart' : 'click';
    parameter = {passive: true};
    if(touchEvent==="ontouchstart"){
        parameter = {passive: true};
    }
    scrollBtn.addEventListener(touchEvent, scrollTo, parameter);

})();


  // Disable hover effects while scrolling
(function() {

    const ENABLE_HOVER_DELAY = 300;
    let timer;
    window.addEventListener('scroll', function() {
        const bodyClassList = document.body.classList;
        // clear previous timeout function
        clearTimeout(timer);

        if (!bodyClassList.contains('disable-hover')) {
            // add the disable-hover class to the body element
            bodyClassList.add('disable-hover');
        }

        timer = setTimeout(function() {
            // remove the disable-hover class after a timeout of 500 millis
            bodyClassList.remove('disable-hover');
        }, ENABLE_HOVER_DELAY);

    }, {passive: true});




})();




// Hide gradient after hero
(function() {

    const body = document.body;
        // clear previous timeout function
    let yPos = window.scrollY;
    if(yPos<=0){
        body.classList.remove("smaller_nav");
    }else{
        body.classList.add("smaller_nav");
    }

    window.addEventListener('scroll', function() {
        const body = document.body;
        // clear previous timeout function
        let yPos = window.scrollY;
        if(yPos<=0){
            body.classList.remove("smaller_nav");
        }else{
            body.classList.add("smaller_nav");

        }

    }, {passive: true});


})();


(function() {
    let strike = document.querySelectorAll('h2 s, h3 s, p s');

    const options = {
        root: null,
        threshold: 0.9
    }

    observer = new IntersectionObserver((entries) =>{
        entries.forEach((element) => {
            if(element.isIntersecting){
                element.target.classList.add("draw");
            }


		});

    }, options)

    strike.forEach(item => {
        observer.observe(item);

    })


})();



//Show scroll to top at footer
(function() {
    let footer = document.querySelectorAll('footer');
    let scrollBtn = document.querySelector('#scrollToTop');

    const options = {
        root: null,
        threshold: 0,
    }

    observer = new IntersectionObserver((entries) =>{
        entries.forEach((element) => {
            if(!element.isIntersecting){
                scrollBtn.classList.remove("active");


            }
            else{
                scrollBtn.classList.add("active");

            }

		},{

        }
        );

    }, options)

    footer.forEach(item => {
        observer.observe(item);

    })



})();

(function() {

	let video = document.querySelectorAll('.observer');

    observer = new IntersectionObserver((entries) =>{
        entries.forEach((element) => {
            if(element.intersectionRatio > 0){
                if(element.target.nodeName === "VIDEO"){
                    element.target.play();
                }

            }
            else{
                //element.target.style.animation = `none`;

            }

		});

    })

    video.forEach(item => {
        observer.observe(item);

    })

    let blocks = document.querySelectorAll('.wp-block-column .wp-block-group');

    const options = {
        root: null,
        rootMargin: '40px',

    }

    observer = new IntersectionObserver((entries) =>{
        entries.forEach((element) => {
            if(element.isIntersecting){
                element.target.classList.add("fadeIn");

            }
            else{
                // element.target.classList.remove("fadeIn");

            }

		},{

        }
        );

    }, options)

    blocks.forEach(item => {
        observer.observe(item);

    })



})();

(function() {
    let references = document.querySelectorAll('section.references > div > article, section.archive > div > article');

    const options = {
        root: null,
        // threshold: -0.1,
        rootMargin: '60px',

    }

    observer = new IntersectionObserver((entries) =>{
        entries.forEach((element) => {
            if(element.isIntersecting){
                element.target.classList.add("fadeIn");

            }
            else{
                // element.target.classList.remove("fadeIn");

            }

		},{

        }
        );

    }, options)

    references.forEach(item => {
        observer.observe(item);

    })

})();
