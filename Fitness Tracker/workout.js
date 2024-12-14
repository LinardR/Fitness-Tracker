document.addEventListener("DOMContentLoaded", () => {
    const workoutForm = document.getElementById("workout-form");
    const historyBody = document.getElementById("history-body");
  
    function loadWorkouts() {
      const workouts = JSON.parse(localStorage.getItem("workoutHistory")) || [];
      historyBody.innerHTML = "";
      workouts.forEach((workout, index) => addWorkoutToTable(workout, index));
    }
  
    function saveWorkouts(workouts) {
      localStorage.setItem("workoutHistory", JSON.stringify(workouts));
    }
  
    function addWorkoutToTable(workout, index) {
      const row = document.createElement("tr");
  
      row.innerHTML = `
        <td>${workout.date}</td>
        <td>${workout.exercise}</td>
        <td>${workout.reps}</td>
        <td>${workout.sets}</td>
        <td>
          <button class="delete-btn" data-index="${index}">Delete</button>
        </td>
      `;
  
      historyBody.appendChild(row);
    }
  
    workoutForm.addEventListener("submit", (event) => {
      event.preventDefault();
  
      const newWorkout = {
        date: workoutForm.date.value,
        exercise: workoutForm.exercise.value,
        reps: workoutForm.reps.value || "-",
        sets: workoutForm.sets.value || "-",
      };
  
      const workouts = JSON.parse(localStorage.getItem("workoutHistory")) || [];
      workouts.push(newWorkout);
      saveWorkouts(workouts);
  
      addWorkoutToTable(newWorkout, workouts.length - 1);
      workoutForm.reset();
    });
  
    historyBody.addEventListener("click", (event) => {
      if (event.target.classList.contains("delete-btn")) {
        const index = event.target.dataset.index;
        const workouts = JSON.parse(localStorage.getItem("workoutHistory")) || [];
        workouts.splice(index, 1);
        saveWorkouts(workouts);
        loadWorkouts();
      }
    });
  
    loadWorkouts();
  });
  