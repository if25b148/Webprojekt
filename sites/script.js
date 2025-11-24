function showForm(formId){
    document.querySelectorAll(".login-container").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}