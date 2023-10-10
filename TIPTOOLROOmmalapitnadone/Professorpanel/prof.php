<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>TIP</title>
  <style>
    /* CSS styles for the layout */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.container {
  display: flex;
  height: 100vh;
}

.sidebar {
  background-color: #f4f4f4;
  color: #333;
  padding: 20px;
  width: 250px;
  height: 100vh;
  position: fixed;
  z-index: 1;
  overflow-y: auto;
  transition: width 0.3s ease;
}

.sidebar:hover {
  width: 300px;
}

.sidebar h2 {
  color: #333;
  font-size: 24px;
  font-weight: bold;
  letter-spacing: 2px;
  margin-bottom: 20px;
}

.sidebar h3 {
  color: #333;
  font-size: 18px;
  margin-bottom: 10px;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  margin-bottom: 10px;
}

.sidebar a {
  color: #333;
  text-decoration: none;
  display: block;
  transition: color 0.3s ease;
}

.sidebar a:hover {
  color: #666;
}

.content {
  flex-grow: 1;
  padding: 20px;
  margin-left: 250px;
}

.email-list-item {
  border-bottom: 1px solid #eee;
  padding: 10px;
  cursor: pointer;
}

.email-list-item:last-child {
  border-bottom: none;
}

.email-list-item.active {
  background-color: #f0f0f0;
}

.email-list-item .sender {
  font-weight: bold;
}

.email-list-item .subject {
  font-weight: bold;
  margin-top: 5px;
}

.email-list-item .date {
  font-size: 12px;
  color: #888;
}

.email-details {
  padding: 20px;
  background-color: #fff;
  border: 1px solid #eee;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

.email-details h2 {
  margin-bottom: 10px;
}

.email-details p {
  margin-bottom: 5px;
}

.email-actions {
  margin-top: 10px;
}

.email-actions button {
  padding: 10px 20px;
  border-radius: 5px;
  margin-right: 10px;
  cursor: pointer;
}

.email-actions button:first-child {
  background-color: #4CAF50;
  color: #fff;
}

.email-actions button:last-child {
  background-color: #f44336;
  color: #fff;
}

.logout-profile {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 20px;
}

.logout-profile #profile {
  font-weight: bold;
  margin-right: 10px;
}

/* Media Queries for Responsive Design */
@media screen and (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    height: auto;
    position: static;
    margin-bottom: 20px;
    overflow-y: visible;
  }

  .content {
    margin-left: 0;
  }
}

    /* CSS styles for the layout */
    /* ... CSS styles omitted for brevity ... */

    /* Updated CSS styles for aesthetics */
    .sidebar h2 {
      font-size: 28px;
      margin-bottom: 30px;
    }

    .profile-info {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .profile-info .profile {
      display: flex;
      align-items: center;
    }

    .profile-info .profile-picture {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }

    .profile-info .professor-name {
      font-size: 18px;
      font-weight: bold;
    }

    #logoutBtn {
      padding: 8px 16px;
      border-radius: 5px;
      background-color: #f44336;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    #logoutBtn:hover {
      background-color: #d32f2f;
    }

    .email-list-item.active {
      background-color: #f0f0f0;
      font-weight: bold;
    }

    .email-details h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .email-details p {
      margin-bottom: 10px;
    }

    .email-details ul {
      margin-top: 5px;
      margin-bottom: 20px;
      list-style-type: none;
      padding: 0;
    }

    .email-details ul li {
      margin-bottom: 5px;
    }

    .email-actions button {
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .email-actions button:first-child {
      background-color: #4CAF50;
      color: #fff;
    }

    .email-actions button:last-child {
      background-color: #f44336;
      color: #fff;
    }

    .email-actions button:hover {
      opacity: 0.8;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>TIP Toolroom</h2>
      <h3>Professors Panel</h3>
      <div class="profile-info">
        <div class="profile">
          <img src="professor-profile-picture.jpg" alt="Profile Picture" class="profile-picture">
          <span id="professorName" class="professor-name"><?php echo $_SESSION['name']; ?></span>
        </div>
        <button id="logoutBtn">Logout</button>
      </div>
      <ul id="emailList"></ul>
    </div>
    <div class="content">
      <div class="email-details">
        <h2 id="requestTitle"></h2>
        <p><strong>Name:</strong> <span id="name"></span></p>
        <p><strong>Student ID:</strong> <span id="studentID"></span></p>
        <p><strong>Course Code:</strong> <span id="courseCode"></span></p>
        <p><strong>Request Date:</strong> <span id="requestDate"></span></p>
        <p><strong>Items:</strong></p>
        <ul id="itemList"></ul>
        <div class="email-actions">
          <button id="confirmBtn">Confirm</button>
          <button id="rejectBtn">Reject</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function fetchData() {
      // Simulating data retrieval from the backend
      const data = {
        professor: {
          name: "<?php echo $_SESSION['name']; ?>",
          profilePicture: "professor-profile-picture.jpg"
        },
        emailList: [
          { id: 1, sender: "Juan", subject: "Request for Toolroom" },
          { id: 2, sender: "John", subject: "Request for Equipment" },
          { id: 3, sender: "Popoy", subject: "Request for Supplies" }
        ],
        selectedEmail: {
          name: "Juan",
          studentID: "123456",
          courseCode: "ABC123",
          requestDate: "June 1, 2023",
          items: [
            { name: "Tool 1", quantity: 2 },
            { name: "Tool 2", quantity: 1 },
            { name: "Tool 3", quantity: 3 }
          ]
        }
      };

      // Set the professor's name and profile picture
      document.getElementById("professorName").textContent = data.professor.name;
      const profilePicture = document.querySelector(".profile-picture");
      profilePicture.src = data.professor.profilePicture;
      profilePicture.alt = "Profile Picture of " + data.professor.name;

      // Populate the email list
      const emailList = document.getElementById("emailList");
      data.emailList.forEach(email => {
        const listItem = document.createElement("li");
        listItem.innerHTML = `<a href="#" class="email-list-item">${email.sender} - ${email.subject}</a>`;
        emailList.appendChild(listItem);
      });

      // Populate the selected email details
      const selectedEmail = data.selectedEmail;
      document.getElementById("requestTitle").textContent = "Request Details";
      document.getElementById("name").textContent = selectedEmail.name;
      document.getElementById("studentID").textContent = selectedEmail.studentID;
      document.getElementById("courseCode").textContent = selectedEmail.courseCode;
      document.getElementById("requestDate").textContent = selectedEmail.requestDate;

      const itemList = document.getElementById("itemList");
      selectedEmail.items.forEach(item => {
        const listItem = document.createElement("li");
        listItem.textContent = `${item.name} - Quantity: ${item.quantity}`;
        itemList.appendChild(listItem);
      });

      // Attach event listeners to the buttons
      document.getElementById("confirmBtn").addEventListener("click", confirmRequest);
      document.getElementById("rejectBtn").addEventListener("click", rejectRequest);
      document.getElementById("logoutBtn").addEventListener("click", logout);
    }

    // Event handler for confirming a request
    function confirmRequest() {
      alert("Request confirmed.");
    }

    // Event handler for rejecting a request
    function rejectRequest() {
      alert("Request rejected.");
    }

    // Event handler for logging out
    function logout() {
      alert("Logged out.");
    }

    // Fetch data and populate the HTML once the DOM is loaded
    document.addEventListener("DOMContentLoaded", fetchData);
  </script>
</body>
</html>