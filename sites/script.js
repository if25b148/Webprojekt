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
