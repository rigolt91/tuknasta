window.addEventListener('DOMContentLoaded', function(e) {
    const divLoadding = document.getElementById('loadding');
    const divContent = document.getElementById('content');

    //Hidde Loadding Page and Show Content
    divLoadding.classList.add("hidden");
    divContent.classList.remove("hidden");

    //Scroll
    const btnUp = document.getElementById('btnUp');
    btnUp.style.opacity = 0;

    window.onscroll = function() {
        const btnUp = document.getElementById('btnUp');
        const navBarFixed = document.getElementById('navBarFixed');

        var y = window.scrollY;

        if(y > 0) {
            navBarFixed.classList.remove('hidden');
            btnUp.classList.remove('hidden');
            fade();
        }

        if(y < 10){
            btnUp.style.opacity = 0;
            fade();
            btnUp.classList.add('hidden');
            navBarFixed.classList.add('hidden');
        }

        function fade() {
            let val = parseFloat(btnUp.style.opacity);

            if (!((val += 0.01) > 1)) {
                btnUp.style.opacity = val;
                requestAnimationFrame(fade);
            }
        }
    };

    //Event Button Scroll Up
    btnUp.addEventListener('click', () => {
        y = window.scrollY;
        window.scroll({
            top: divContent,
            behavior: "smooth"
        });
    });

    function navBarFixed() {}
});
