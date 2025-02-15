<?php


require_once 'module/db.php';
// Kết nối cơ sở dữ liệu
$db = new Database();
$conn = $db->connect();

// Lấy dữ liệu từ GET nếu tồn tại
$city_from = isset($_GET['city_from']) ? $_GET['city_from'] : null;
$city_from_name = isset($_GET['city_from_name']) ? $_GET['city_from_name'] : '';
$city_to = isset($_GET['city_to']) ? $_GET['city_to'] : null;
$city_to_name = isset($_GET['city_to_name']) ? $_GET['city_to_name'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : null;
?>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <title>Ngày tháng năm</title>
  </head>

<div class="container-xl shadow-lg p-3 mb-5 bg-white rounded">
    <div class="booking_m clearfix bg-white">
        <form action="trip_results.php" method="GET">
            <div class="row booking_1 mb-4">
                <div class="col-md-12">
                    <h4 class="mb-0">Tìm chuyến xe</h4>
                </div>
            </div>
            <div class="row booking_2 align-items-center">
                <!-- Điểm đi -->
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i position-relative">
                        <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đi</h6>
                        <input type="text" class="form-control" id="city_from" name="city_from_name" placeholder="Nhập điểm đi" autocomplete="off" value="<?= htmlspecialchars($city_from_name) ?>" required>
                        <input type="hidden" id="city_from_id" name="city_from" value="<?= htmlspecialchars($city_from) ?>">
                        <div id="city_from_suggestions" class="suggestions-box"></div>
                    </div>
                </div>
                <!-- Điểm đến -->
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i position-relative">
                        <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đến</h6>
                        <input type="text" class="form-control" id="city_to" name="city_to_name" placeholder="Nhập điểm đến" autocomplete="off" value="<?= htmlspecialchars($city_to_name) ?>" required>
                        <input type="hidden" id="city_to_id" name="city_to" value="<?= htmlspecialchars($city_to) ?>">
                        <div id="city_to_suggestions" class="suggestions-box"></div>
                    </div>
                </div>
                <!-- Ngày đi -->
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-calendar me-1 col_oran"></i> Ngày đi</h6>
                        <input class="form-control" type="date" name="date" value="<?= htmlspecialchars($date) ?>" min="<?= date('Y-m-d') ?>" required>

                    </div>
                </div>
                <!-- Nút tìm -->
                <div class="col-md-3 col-sm-12 text-center">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-search me-1 col_oran"></i> Tìm</h6>
                        <button type="submit" class="button pt-2 pb-2 ps-4 pe-4 d-inline-block w-100">Tìm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    

<!-- Styles for suggestions -->
<style>
  .suggestions-box {
    border: 1px solid #ddd;
    background-color: #fff;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    z-index: 1000;
    width: 100%; /* Hộp gợi ý sẽ khớp với chiều rộng của ô input */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng đổ bóng */
    border-radius: 4px; /* Bo góc nhẹ để đẹp hơn */
}
.suggestion-item {
    padding: 8px;
    cursor: pointer;
}
.suggestion-item:hover {
    background-color: #f0f0f0;
}

</style>

<!-- JavaScript for dynamic suggestions -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cityFromInput = document.getElementById("city_from");
        const cityFromId = document.getElementById("city_from_id");
        const cityFromSuggestions = document.getElementById("city_from_suggestions");

        const cityToInput = document.getElementById("city_to");
        const cityToId = document.getElementById("city_to_id");
        const cityToSuggestions = document.getElementById("city_to_suggestions");

        function fetchSuggestions(input, suggestionsBox, hiddenInput) {
            input.addEventListener("input", function () {
                const query = input.value.trim();
                if (query.length > 0) {
                    fetch(`module/search_city.php?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsBox.innerHTML = "";
                            suggestionsBox.style.display = "block";
                            data.forEach(city => {
                                const div = document.createElement("div");
                                div.classList.add("suggestion-item");
                                div.textContent = city.city_name;
                                div.dataset.id = city.id_city;

                                div.addEventListener("click", function () {
                                    input.value = city.city_name;
                                    hiddenInput.value = city.id_city;
                                    suggestionsBox.style.display = "none";
                                });

                                suggestionsBox.appendChild(div);
                            });
                        })
                        .catch(error => console.error("Error fetching suggestions:", error));
                } else {
                    suggestionsBox.style.display = "none";
                }
            });

            document.addEventListener("click", function (e) {
                if (!suggestionsBox.contains(e.target) && e.target !== input) {
                    suggestionsBox.style.display = "none";
                }
            });
        }

        fetchSuggestions(cityFromInput, cityFromSuggestions, cityFromId);
        fetchSuggestions(cityToInput, cityToSuggestions, cityToId);
    });
</script>
