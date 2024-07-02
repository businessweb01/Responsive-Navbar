<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="nav.css">
    <script src="node_modules/boxicons/dist/boxicons.js"></script>
</head>
<body>
<!-- Navigation -->
    <header class="header">
        <nav class="navigation">
            <div class="nav-links">
                <a href="#" class="nav-link">Home</a>
                <a href="#" class="nav-link">Courses</a>
                <a href="#" class="nav-link">Transactions</a>
                <a href="#" class="nav-link">Dashboard</a>
            </div>
            <div class="nav-icons">
                <a href="#" class="nav-icon"><box-icon name='user-circle' color='#fff' type="solid" size="max(1.5vw, 20px)"></box-icon></a>
                <a href="#" class="nav-icon"><box-icon name='bell' color='#fff' type="solid" size="max(1.5vw, 20px)"class="bell-icon"></box-icon></a>
            </div>
        </nav>
    </header>
<!-- End of Navigation -->
<!-- Start of Content -->
    <div class="content">

        <div class="box1">
            <div class="logo"><span class="Agri">Agri</span><span>Learn</span></div>

            <div class="box1-buttons">
                <button class="add-course" id="add-course">Add Course</button>
                <button class="archives" id="archives">Archives</button>
            </div>

            <div class="storage-info">
                <p>Storage</p>
                <div class="progress-bar">
                    <div class="progress" style="width: 50%;"></div> <!-- Example: 50% progress -->
                </div>
                <p><span id="used-storage"></span> of 10 MB used</p>
            </div>

        </div>

        <div class="box2">
            <!-- Box2 Header -->
            <div class="courses">
                <p>Courses <box-icon type='solid' name='book-open' size='max(1.5vw, 25px)'></box-icon></p>
            </div>
            <!-- Search -->
            <div class="search-container">
                <input type="text" placeholder="Search...">
                <button type="submit">Search</button>
            </div>

            <!-- Box2 Content -->
             <div class="course-list">
                <table class="course-list">
                    <tr>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th>Lesson</th>
                        <th>Category</th>
                        <th>Difficulty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>

                    <tr>
                        <td>Course 1</td>
                        <td>Description 1</td>
                        <td>Lesson 1</td>
                        <td>Category 1</td>
                        <td>Easy</td>
                        <td>$10</td>
                        <td><button class="edit">Edit</button><button class="delete">Delete</button><button class="add-quiz">Add Quiz</button></td>
                    </tr>
                </table>
             </div>
        </div>

    </div>
    <script>
         let add = document.getElementById("add-course");
         let archive = document.getElementById("archives");

        add.addEventListener('click', () => {
            add.classList.toggle('button-clicked');
            archive.classList.remove('button-clicked');
        });

        archive.addEventListener('click', () => {
            archive.classList.toggle('button-clicked');
            add.classList.remove('button-clicked');
        });
       let previousStorageSize = null; // Variable to store the previous storage size

// Function to fetch and update storage information
        async function fetchAndCalculateStorage() {
            try {
                const response = await fetch('storageCalc.php');
                if (!response.ok) {
                    throw new Error('Failed to fetch storage data');
                }
                const data = await response.json();
                const storageUsed = data.size;
                const unit = data.unit;
                let storageUsedDisplay;

                // Ensure the displayed storage does not exceed 100 MB
                if (storageUsed >= 1024) {
                    storageUsedDisplay = (Math.min(storageUsed / 1024, 100)).toFixed(2) + ' GB';
                } else {
                    storageUsedDisplay = (Math.min(storageUsed, 100)).toFixed(2) + ' MB';
                }

                // Update display only if there's a change in storage size
                if (storageUsed !== previousStorageSize) {
                    updateStorageUsed(storageUsedDisplay, unit);
                    previousStorageSize = storageUsed; // Update previous storage size
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                document.getElementById('used-storage').textContent = 'Error fetching data';
            }
        }

        // Function to update storage display and progress bar
        function updateStorageUsed(storageUsed, unit) {
            const progressBar = document.querySelector('.progress');
            const usedStorageSpan = document.getElementById('used-storage');

            // Convert storageUsed to a number
            const parsedStorageUsed = parseFloat(storageUsed);

            // Display the storage used with proper formatting
            usedStorageSpan.textContent = `${storageUsed} used`;

            // Calculate progress bar width based on unit
            let progressWidth;
            const maxStorage = 10; // Maximum storage in MB
            progressWidth = (parsedStorageUsed / maxStorage) * 100;
            // Set progress bar width
            progressBar.style.width = `${progressWidth}%`;
        }

        // Example usage: Initial fetch and calculation of storage used
        fetchAndCalculateStorage();

        // Automatically fetch and update storage information every 5 minutes
        setInterval(fetchAndCalculateStorage, 5 * 60 * 1000); // Update every 5 minutes



    </script>
</body>
</html>