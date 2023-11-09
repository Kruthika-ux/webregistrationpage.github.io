const form = document.getElementById('registration-form');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const umid = form.elements.umid.value;
  const firstName = form.elements.first_name.value;
  const lastName = form.elements.last_name.value;
  const projectTitle = form.elements.project_title.value;
  const email = form.elements.email.value;
  const phoneNumber = form.elements.phone_number.value;
  const timeSlot = form.elements.time_slot.value;

  // Validation

})
