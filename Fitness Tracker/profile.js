document.addEventListener("DOMContentLoaded", () => {
    const profileForm = document.getElementById("profile-form");
    const profileDisplay = document.getElementById("profile-display");
  
    const nameInput = document.getElementById("name");
    const ageInput = document.getElementById("age");
    const weightInput = document.getElementById("weight");
    const heightInput = document.getElementById("height");
    const goalsInput = document.getElementById("goals");
  
    const displayName = document.getElementById("display-name");
    const displayAge = document.getElementById("display-age");
    const displayWeight = document.getElementById("display-weight");
    const displayHeight = document.getElementById("display-height");
    const displayGoals = document.getElementById("display-goals");
  
    const editProfileButton = document.getElementById("edit-profile");
  
    function loadProfile() {
      const profile = JSON.parse(localStorage.getItem("userProfile"));
      if (profile) {
        nameInput.value = profile.name;
        ageInput.value = profile.age;
        weightInput.value = profile.weight;
        heightInput.value = profile.height;
        goalsInput.value = profile.goals;
  
        displayName.textContent = profile.name;
        displayAge.textContent = profile.age;
        displayWeight.textContent = profile.weight;
        displayHeight.textContent = profile.height;
        displayGoals.textContent = profile.goals;
  
        profileForm.style.display = "none";
        profileDisplay.style.display = "block";
      }
    }
  
    function saveProfile(event) {
      event.preventDefault();
      const profile = {
        name: nameInput.value,
        age: ageInput.value,
        weight: weightInput.value,
        height: heightInput.value,
        goals: goalsInput.value,
      };
      localStorage.setItem("userProfile", JSON.stringify(profile));
  
      displayName.textContent = profile.name;
      displayAge.textContent = profile.age;
      displayWeight.textContent = profile.weight;
      displayHeight.textContent = profile.height;
      displayGoals.textContent = profile.goals;
  
      profileForm.style.display = "none";
      profileDisplay.style.display = "block";
    }

    function editProfile() {
      profileForm.style.display = "block";
      profileDisplay.style.display = "none";
    }
  
    profileForm.addEventListener("submit", saveProfile);
    editProfileButton.addEventListener("click", editProfile);

    loadProfile();
  });
  