//das ist damit man von Regisrieren auf login springt ohne eine eigene Unterseite zu bruachen
function showForm(formId){
    document.querySelectorAll(".login-container").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}

//fuer Seite faq.html, damit die Frage aufgeklappt wird
document.querySelectorAll('.question').forEach(q => {
    q.addEventListener('click', () => {
        const answer = q.nextElementSibling;
        answer.style.display =
            answer.style.display === "block" ? "none" : "block";
    });
});

//fuer Seite kursinfos.php, damit die Informationen zum Kurs aufgeklappt werden
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.kurs-item').forEach(item => {
        const title = item.querySelector('.kurs-title');
        const details = item.querySelector('.kurs-details');

        title.addEventListener('click', () => {
            if(item.classList.contains('active')){
                // schließen
                details.style.maxHeight = '0px';
                item.classList.remove('active');
            } else {
                // öffnen: ScrollHeight exakt setzen
                details.style.maxHeight = details.scrollHeight + "px";
                item.classList.add('active');
            }
        });
    });
});








