$(document).ready(function () {
    // Sample district data for all 25 districts
    const districtData = {
        1: {
            name: "Galle",
            image: "img/calender7.jpg",
            description: "Description for Galle."
        },
        2: {
            name: "Matara",
            image: "img/calender7.jpg",
            description: "Description for Matara."
        },
        3: {
            name: "Hambantota",
            image: "img/calender7.jpg",
            description: "Description for Hambantota."
        },
        4: {
            name: "Colombo",
            image: "img/calender7.jpg",
            description: "Description for Colombo."
        },
        5: {
            name: "Gampaha",
            image: "img/calender7.jpg",
            description: "Description for Gampaha."
        },
        6: {
            name: "Kalutara",
            image: "img/calender7.jpg",
            description: "Description for Kalutara."
        },
        7: {
            name: "Kandy",
            image: "img/calender7.jpg",
            description: "Description for Kandy."
        },
        8: {
            name: "Matale",
            image: "img/calender7.jpg",
            description: "Description for Matale."
        },
        9: {
            name: "Nuwara Eliya",
            image: "img/calender7.jpg",
            description: "Description for Nuwara Eliya."
        },
        10: {
            name: "Jaffna",
            image: "img/calender7.jpg",
            description: "Description for Jaffna."
        },
        11: {
            name: "Kilinochchi",
            image: "img/calender7.jpg",
            description: "Description for Kilinochchi."
        },
        12: {
            name: "Mannar",
            image: "img/calender7.jpg",
            description: "Description for Mannar."
        },
        13: {
            name: "Vavuniya",
            image: "img/calender7.jpg",
            description: "Description for Vavuniya."
        },
        14: {
            name: "Mullaitivu",
            image: "img/calender7.jpg",
            description: "Description for Mullaitivu."
        },
        15: {
            name: "Anuradhapura",
            image: "img/calender7.jpg",
            description: "Description for Anuradhapura."
        },
        16: {
            name: "Polonnaruwa",
            image: "img/calender7.jpg",
            description: "Description for Polonnaruwa."
        },
        17: {
            name: "Trincomalee",
            image: "img/calender7.jpg",
            description: "Description for Trincomalee."
        },
        18: {
            name: "Batticaloa",
            image: "img/calender7.jpg",
            description: "Description for Batticaloa."
        },
        19: {
            name: "Ampara",
            image: "img/calender7.jpg",
            description: "Description for Ampara."
        },
        20: {
            name: "Puttalam",
            image: "img/calender7.jpg",
            description: "Description for Puttalam."
        },
        21: {
            name: "Kurunegala",
            image: "img/calender7.jpg",
            description: "Description for Kurunegala."
        },
        22: {
            name: "Ratnapura",
            image: "img/calender7.jpg",
            description: "Description for Ratnapura."
        },
        23: {
            name: "Kegalle",
            image: "img/calender7.jpg",
            description: "Description for Kegalle."
        },
        24: {
            name: "Badulla",
            image: "img/calender7.jpg",
            description: "Description for Badulla."
        },
        25: {
            name: "Monaragala",
            image: "img/calender7.jpg",
            description: "Description for Monaragala."
        }
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