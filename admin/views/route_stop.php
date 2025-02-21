<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
<?php
$db = new Database();
$conn = $db->connectBee();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tuyến xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách điểm dừng</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý điểm dừng</li>
                </ol>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm ">
                <button class="btn btn-outline-secondary" id="btnSearch">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

            <!-- Add -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Tạo điểm dừng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/route_sp.php" method="POST">
                                <div class="mb-3">
                                    <label for="route_info" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="route_info" name="route_info" required>
                                        <?php
                                        $query_route = "
                                        SELECT 
                                            route.id_route,
                                            car_house.name_c_house,
                                            city_from.city_name AS city_from,
                                            city_to.city_name AS city_to
                                        FROM 
                                            route
                                        INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
                                        INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
                                        INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city";

                                        $result_route = $conn->query($query_route);
                                        while ($row_route = $result_route->fetch_assoc()) {
                                            $id_route = $row_route['id_route'];
                                            $name_c_house = $row_route['name_c_house'];
                                            $city_from = $row_route['city_from'];
                                            $city_to = $row_route['city_to'];
                                            echo "<option value='$id_route'>$name_c_house - $city_from → $city_to</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="route_stop-container">
                                    <label class="form-label">Danh sách tỉnh</label>
                                    <div class="d-flex align-items-center mb-2" id="route-stop-row">
                                        <input type="text" class="form-control ms" id="route_stop" name="route_stop[]" placeholder="Tên thành phố" list="city-list" required>
                                        <datalist id="city-list">
                                            <?php
                                            $query_city = "SELECT id_city, city_name FROM city";
                                            $result_city = $conn->query($query_city);
                                            while ($row_city = $result_city->fetch_assoc()) {
                                                echo "<option value='{$row_city['city_name']}' data-id='{$row_city['id_city']}'>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="text" class="form-control ms-2 number-stop" name="number_stop[]" placeholder="Số thứ tự dừng" required>
                                        <button type="button" class="btn btn-success ms-2" id="add-route-stop">+</button>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="add">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Tạo điểm dừng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/route_sp.php" method="POST">
                                <div class="mb-3">
                                    <label for="route_info" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="route_info" name="route_info" required>
                                        <?php
                                        $query_route = "
                            SELECT 
                                route.id_route,
                                car_house.name_c_house,
                                city_from.city_name AS city_from,
                                city_to.city_name AS city_to
                            FROM 
                                route
                            INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
                            INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
                            INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city";

                                        $result_route = $conn->query($query_route);
                                        while ($row_route = $result_route->fetch_assoc()) {
                                            $id_route = $row_route['id_route'];
                                            $name_c_house = $row_route['name_c_house'];
                                            $city_from = $row_route['city_from'];
                                            $city_to = $row_route['city_to'];
                                            echo "<option value='$id_route'>$name_c_house - $city_from → $city_to</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="route_stop-container">
                                    <label class="form-label">Danh sách tỉnh</label>
                                    <div class="d-flex align-items-center mb-2" id="route-stop-row">
                                        <input type="text" class="form-control ms" id="route_stop" name="route_stop[]" placeholder="Tên thành phố" list="city-list" required>
                                        <datalist id="city-list">
                                            <?php
                                            $query_city = "SELECT id_city, city_name FROM city";
                                            $result_city = $conn->query($query_city);
                                            while ($row_city = $result_city->fetch_assoc()) {
                                                echo "<option value='{$row_city['city_name']}' data-id='{$row_city['id_city']}'>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="text" class="form-control ms-2 number-stop" name="number_stop[]" placeholder="Số thứ tự dừng" required>
                                        <button type="button" class="btn btn-success ms-2" id="add-route-stop">+</button>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="add">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa điểm dừng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/route_sp.php" method="POST">
                                <input type="hidden" name="id_route" id="editId_route_stop">
                                <div class="mb-3">
                                    <label for="route_info" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="eidt_route_info" name="route_info" required>
                                        <?php
                                        $query_route = "
                            SELECT 
                                route.id_route,
                                car_house.name_c_house,
                                city_from.city_name AS city_from,   
                                city_to.city_name AS city_to
                            FROM
                                route
                            INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
                            INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
                            INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city";

                                        $result_route = $conn->query($query_route);
                                        while ($row_route = $result_route->fetch_assoc()) {
                                            $id_route = $row_route['id_route'];
                                            $name_c_house = $row_route['name_c_house'];
                                            $city_from = $row_route['city_from'];
                                            $city_to = $row_route['city_to'];
                                            echo "<option value='$id_route'>$name_c_house - $city_from → $city_to</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="route_stop-container">
                                    <label class="form-label">Danh sách tỉnh</label>
                                    <div class="d-flex align-items-center mb-2" id="route-stop-row">
                                        <input type="text" class="form-control ms" id="edit_route_stop" name="route_stop[]" placeholder="Tên thành phố" list="city-list" required>
                                        <datalist id="city-list">
                                            <?php
                                            $query_city = "SELECT id_city, city_name FROM city";
                                            $result_city = $conn->query($query_city);
                                            while ($row_city = $result_city->fetch_assoc()) {
                                                echo "<option value='{$row_city['city_name']}' data-id='{$row_city['id_city']}'>";
                                            }
                                            ?>
                                        </datalist>
                                        <input type="text" class="form-control ms-2 number-stop" name="edit_number_stop[]" placeholder="Số thứ tự dừng" required>
                                        <button type="button" class="btn btn-success ms-2" id="add-route-stop">+</button>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="edit">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Xóa điểm dừng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa điểm dừng này không?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="../module/route_sp.php" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_route" id="deleteId_route">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="text-center">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Nhà xe</th>
                            <th>Tuyến đường</th>
                            <!-- <th>Điểm dừng</th> -->
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $searchKeyword = $_POST['search_keyword'] ?? '';

                        $query = "
            SELECT route_stop.id_route_stop,
                   route.id_route, 
                   car_house.name_c_house, 
                   city_from.city_name AS l_pick, 
                   city_to.city_name AS l_drop, 
                   GROUP_CONCAT(city.city_name ORDER BY route_stop.type SEPARATOR ' → ') AS route_name
            FROM route
            INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
            INNER JOIN route_stop ON route.id_route = route_stop.id_route
            INNER JOIN city ON route_stop.id_city = city.id_city
            INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
            INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city
            WHERE car_house.name_c_house LIKE ?
            GROUP BY route.id_route, car_house.name_c_house, city_from.city_name, city_to.city_name";

                        $stmt = $conn->prepare($query);
                        $searchLike = "%" . $searchKeyword . "%";
                        $stmt->bind_param("s", $searchLike);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $Stt = 1;
                        while ($row = $result->fetch_assoc()) {

                            $routeDetails = $row['l_pick'] . ' → ' . $row['route_name'] . ' → ' . $row['l_drop'];
                            $stopsDetails = $row['route_name'];
                            echo "<tr>";
                            echo "<td>{$Stt}</td>";
                            echo "<td>{$row['id_route_stop']}</td>";
                            echo "<td>{$row['name_c_house']}</td>";
                            echo "<td>{$routeDetails}</td>";
                            // echo "<td>{$stopsDetails}</td>";
                            echo "<td>
                        <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='{$row['id_route_stop']}'>
                            <i class='fas fa-edit'></i> Sửa
                        </button>
                        <button class='btn btn-danger btn-sm btnDelete' data-id='{$row['id_route']}'>
                            <i class='fas fa-trash-alt'></i> Xóa
                        </button>
                    </td>";
                            echo "</tr>";
                            $Stt++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="../js/route_s.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</html>