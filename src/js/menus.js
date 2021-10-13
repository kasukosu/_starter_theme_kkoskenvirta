

(function() {

	let navIcon = document.querySelector('#nav-icon');
    let button = document.querySelector('.hamburger');
	let menu = document.querySelector('#menu-primary');
	let background = document.querySelector('#menu-bg');
    let touchEvent = 'ontouchstart' in window ? 'touchstart' : 'click';
    parameter = {passive: true};
    if(touchEvent==="ontouchstart"){
        parameter = {passive: true};
    }
    button.addEventListener(touchEvent, function (event) {
        console.log(event)

        if(menu.classList.contains('active')){
            navIcon.classList.remove('active');
            menu.classList.remove('active')
            closeMenus();

            return;
        }
        closeMenus();
        navIcon.classList.add('active');
        menu.classList.toggle('active')
        background.classList.toggle('active')
        document.body.classList.toggle('menu-open');
        document.body.classList.toggle('hamburger-open');

    }, parameter);



})();


//Palvelut dropdown

	let dropdown = document.querySelector('li.has-children');
	let menu = document.querySelector('#menu-secondary');
	let background2 = document.querySelector('#menu-bg-2');

    dropdown.addEventListener('click', function (event) {
        event.preventDefault();
        if(menu.classList.contains('active')){
            menu.classList.remove('active')
            closeMenus();
            return;
        }
        closeMenus();
        menu.classList.toggle('active')
        background2.classList.toggle('active')
        document.body.classList.toggle('menu-open');
        document.body.classList.toggle('dropdown-open');

    });



let closeMenus = () => {
    activeMenus = document.querySelectorAll("nav.active, .menu.active, #nav-icon.active");
	let background = document.querySelector('#menu-bg');
    let background2 = document.querySelector('#menu-bg-2');

    activeMenus.forEach(menu => {
        menu.classList.remove('active');
    });

    background.classList.remove('active')
    background2.classList.remove('active')
    document.body.classList.remove('menu-open');
    document.body.classList.remove('hamburger-open');
    document.body.classList.remove('dropdown-open');


}


(function() {

    let image = document.querySelectorAll("section.personnel figure .btn-close");
    let article = document.querySelectorAll("section.personnel article");

    image.forEach((item) => {

        item.addEventListener("click", (e)=>{
            let parent = e.target.parentNode.parentNode;
            if(parent.classList.contains('active')){
                parent.classList.remove("active");

            }
            else{
                parent.classList.add("active");

            }

        })
    })

})();

(function() {
    let togglers = document.querySelectorAll(".side-menu .menu-item-has-children button");
    togglers.forEach((item) => {

        item.addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            let target = e.target.parentNode.parentNode;
            let parent = e.target.parentNode.parentNode.parentNode;

            let siblings = parent.querySelectorAll(':scope>li.menu-item-has-children.active');
            let subMenu = target.querySelector('ul.sub-menu');

            //close all siblings
            // siblings.forEach((item)=> {
            //     let subMenu = item.querySelector('ul.sub-menu.active');
            //     // subMenu.classList.remove('active');
            //     item.classList.remove('active');
            // })

            console.log(target);
            if(subMenu.classList.contains('active')){
                target.classList.remove("active");
                subMenu.classList.remove("active");
                subMenu.style.maxHeight = null;
                item.classList.remove('active');
            }
            else{
                target.classList.add("active");
                subMenu.classList.add("active");
                item.classList.add('active');
                subMenu.style.maxHeight = subMenu.scrollHeight + "px";

            }
            subMenu.addEventListener('transitionstart', () => {
                let subMenus = document.querySelectorAll("ul.active");
                subMenus.forEach((menu) => {
                    menu.style.maxHeight = menu.scrollHeight + "px";

                })

            });



        })
    })

})();

