document.addEventListener('DOMContentLoaded', function () {
    let selectSingle = document.querySelectorAll('.form-selects');
    selectSingle.forEach((element) => {
        new Choices(element, {
            shouldSort: false,
            allowHTML: true
        });
    });
});
