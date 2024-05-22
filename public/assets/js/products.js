document.addEventListener('DOMContentLoaded', function() {
    const coll = document.getElementsByClassName("collapsible");
    for (let i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            const content = document.getElementById(this.getAttribute('data-target'));
            const arrow = this.getElementsByClassName('arrow')[0];
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                arrow.innerHTML = "&#9660;"; // Down arrow
                content.classList.remove('show');
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
                arrow.innerHTML = "&#9650;"; // Up arrow
                content.classList.add('show');
            }
        });
        // Trigger the click event immediately after adding the event listener
        coll[i].click();
    }
});