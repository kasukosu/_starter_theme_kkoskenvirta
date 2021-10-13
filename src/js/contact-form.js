(function() {


    const formsWithAnimatedLabels = document.querySelectorAll(
        ".wpcf7-form"
    );
    const focusedClass = "focused";

    for (const form of formsWithAnimatedLabels) {
        const formControls = form.querySelectorAll(
            '[type="text"], [type="email"], [type="tel"], textarea'
        );
        for (const formControl of formControls) {
            formControl.addEventListener("focus", function () {
                this.parentElement.nextElementSibling.classList.add(focusedClass);
            });

            formControl.addEventListener("blur", function () {
                if (!this.value) {
                    this.parentElement.nextElementSibling.classList.remove(
                        focusedClass
                    );
                }
            });
        }


        form.parentElement.addEventListener("wpcf7mailsent", function () {
            const labels = document.querySelectorAll(".focused");
            for (const label of labels) {
                label.classList.remove(focusedClass);
            }
        });
}

})();
