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
document.querySelectorAll('.kurs-title').forEach(title => {
    title.addEventListener('click', () => {
        const details = title.nextElementSibling;
        // Toggle wie FAQ
        details.style.display = (details.style.display === "block") ? "none" : "block";
    });
});







