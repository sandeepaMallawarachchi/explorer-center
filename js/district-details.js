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
            description: "2021 Population Estimate: 752,000 <br><br> Total Land Area: 4,222 km2 (1,630 mi2) <br><br> Province: Eastern <br><br> The Ampara District is located along the southeastern coast of Sri Lanka, bordering six other districts and the Indian Ocean. It is one of the most diverse districts in the country, and it was formed in 1961 from land that had previously been a part of the Batticaloa District. During the British colonial period, the capital of Ampara was used as a resting ground for hunters. It was later turned into a town and functioned as a place of residence for workers on the Inginiyagala Dam (Gal Oya Dam)."
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
            $('#provinceDescription').html(description);

            $.get(`districts/${districtId}.txt`, function (data) {
                // Process the text data to insert images at appropriate places
                let formattedData = data;

                // Make the topics bold
                formattedData = formattedData.replace(/\*([^\*]+)\*/g, function (match, topic) {
                    return `<strong>${topic}</strong>`;
                });

                // Replace image markdown syntax with <img> tags
                formattedData = formattedData.replace(/!\[([^\]]+)\]\((img\/[a-zA-Z0-9]+\.jpg)\)/g, function (match, altText, imgPath, index) {
                    // Find the image index dynamically and alternate between left and right
                    let imgClass = 'district-image-left'; // Default to left alignment

                    // Check if the image index is even or odd
                    if (formattedData.match(/!\[[^\]]+\]\((img\/[a-zA-Z0-9]+\.jpg)\)/g).indexOf(match) % 2 !== 0) {
                        imgClass = 'district-image-right'; // If index is odd, float right
                    }

                    return `<img src="${imgPath}" alt="${altText}" class="${imgClass}">`;
                });

                // Insert the processed text into the HTML element
                $('#districtDescription').html(formattedData.replace(/\n/g, '<br>'));
            });
        }
    });
});