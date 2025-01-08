$(document).ready(function () {
    // Sample district data
    const districtData = {
        1: {
            name: "Galle",
            image: "img/calender7.jpg",
            description: "Galle is a major city in Sri Lanka, known for its historical Galle Fort.",
        },
        2: {
            name: "Matara",
            image: "img/calender3.jpg",
            description: "Matara is a vibrant city with rich cultural and historical landmarks.",
        },
        3: {
            name: "Hambantota",
            image: "img/hambanthota.jpg",
            description: "Hambantota is a rapidly developing city known for its natural harbors.",
        },
    };

    // Click event for location links
    $('.location-link').on('click', function (e) {
        e.preventDefault(); // Prevent default anchor behavior

        const districtId = $(this).data('id');
        if (districtId && districtData[districtId]) {
            const { name, image, description } = districtData[districtId];

            // Update province details dynamically
            $('#provinceName').text(name);
            $('#provinceImage').attr('src', image).attr('alt', name);
            $('#provinceDescription').text(description);
        }
    });
});