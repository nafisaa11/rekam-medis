<?php include 'templates/header.php'; ?>

<!-- Main Content -->
<div class="container-fluid p-5 d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0">
        <div class="d-flex align-items-center mb-4">
            <img src="templates/img/Shield.png" alt="" class="me-2" style="width: 64px;">
            <h1 class="mb-0">PENS HOSPITAL</h1>
        </div>
        <!-- Left Section -->
        <div class="col-md-7 d-flex justify-content-center align-items-center gradient-bg">
            <div id="carouselExample" class="carousel slide p-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img
                            src="templates/img/DNA.png"
                            alt="DNA"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Medicine.png"
                            alt="Medicine"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Checklist.png"
                            alt="Checklist"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                    <div class="carousel-item">
                        <img
                            src="templates/img/Hearth.png"
                            alt="Hearth"
                            class="d-block carousel-img mx-auto"
                            style="width: 300px; height: auto" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Section -->
        <div class="col-md-5 d-flex align-items-center justify-content-center px-5">
            <div class="card card-login p-5 w-100 shadow-sm rounded-4">
                <h2 class="text-center mb-4">Login Admin</h2>
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label remember-me-label" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>