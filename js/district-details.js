$(document).ready(function () {
  // Sample district data for all 25 districts
  const districtData = {
    1: {
      name: "Galle",
      image: "img/calender7.webp",
      description:
        "2021 Population Estimate: 1,147,000<br><br>Total Land Area: 1,617 km2 (624 mi2)<br><br>Province: Southern<br><br>The Galle District is located in the southeast corner of Sri Lanka and borders the Indian Ocean as well as three other districts. It is the site of the Sinharaja Forest Reserve, a UNESCO World Heritage Site.",
    },
    2: {
      name: "Matara",
      image: "img/PolhenaBeach.webp",
      description:
        "2021 Population Estimate: 873,000<br><br>Total Land Area: 1,270 km2 (490 mi2)<br><br>Province: Southern<br><br>The district of Matara is located in the extreme south of Sri Lanka and contains the country’s southernmost point, Dondra Head, Dondra. Sri Lanka’s tallest lighthouse is located here, and it’s one of the tallest in South East Asia.",
    },
    3: {
      name: "Hambantota",
      image: "img/YalaNationalPark.webp",
      description:
        "2021 Population Estimate: 676,000<br><br>Total Land Area: 2,496 km² (964 mi²)<br><br>Province: Southern<br><br>Hambantota District, located on Sri Lanka’s southeastern coast with a dry climate, is known for salt production and ongoing reconstruction efforts following the 2004 Indian Ocean Tsunami.",
    },
    4: {
      name: "Colombo",
      image: "img/LotusTower.webp",
      description:
        "2021 Population Estimate: 2,480,000<br><br>Total Land Area: 676 km² (261 mi²)<br><br>Province: Western<br><br>Colombo, the most populated and densely populated district in Sri Lanka, serves as the nation's capital. Predominantly Sinhalese, the district also includes Sri Lankan Moor and Tamil communities. Positioned on a key trade route.",
    },
    5: {
      name: "Gampaha",
      image: "img/GampahaBotanicalGarden.webp",
      description:
        "2021 Population Estimate: 2,443,000<br><br>Total Land Area: 1,341 km² (518 mi²)<br><br>Province: Western<br><br>Gampaha, the second most populated district in Sri Lanka after Colombo, lies just north of Colombo and borders four other districts and the Indian Ocean. While Gampaha is the district's capital, Negombo serves as its largest city and economic hub.",
    },
    6: {
      name: "Kalutara",
      image: "img/KalutaraBodhiya.webp",
      description:
        "2021 Population Estimate: 1,296,000<br><br>Total Land Area: 1,576 km² (608 mi²)<br><br>Province: Western<br><br>The Kalutara District, located in southeastern Sri Lanka, has its capital at the point where the Kalu Ganga River meets the ocean",
    },
    7: {
      name: "Kandy",
      image: "img/TempleoftheToothRelic.webp",
      description:
        "2021 Population Estimate: 1,374,000<br><br>Total Land Area: 1,998 km² (771 mi²)<br><br>Province: Central<br><br>Kandy is a major city in central Sri Lanka, known for its rich history and cultural significance. The capital of the Central Province, Kandy is home to the Temple of the Sacred Tooth Relic, a UNESCO World Heritage Site. Surrounded by mountains and lush vegetation, Kandy is a hub for tourism, agriculture, and cultural events such as the Esala Perahera festival.",
    },
    8: {
      name: "Matale",
      image: "img/KnucklesMountainRange.webp",
      description:
        "2021 Population Estimate: 530,000<br><br>Total Land Area: 1,952 km² (754 mi²)<br><br>Province: Central<br><br>Matale, located in the center of Sri Lanka’s Central Hills, has Buddhism as its largest religion, followed by Islam, Hinduism, and Christianity. The district's capital, also called Matale, has an economy based on agriculture, tourism, and trade, with famous spice gardens, surrounding plantations, and the colorful Muthumariamman Hindu Temple.",
    },
    9: {
      name: "Nuwara Eliya",
      image: "img/GregoryLake.webp",
      description:
        "2021 Population Estimate: 780,000 <br><br>Total Land Area: 1,706 km2 (659 mi2)<br><br>Province: Central<br><br>Nestled among the hills of Sri Lanka’s Central Province is the district of Nuwara Eliya. The terrain in this area of the country is mostly mountainous with deep valleys, and the capital of the district is located in what is considered the most important location for tea cultivation in Sri Lanka.",
    },
    10: {
      name: "Jaffna",
      image: "img/NallurKandaswmyKovil.webp",
      description:
        "2021 Population Estimate: 626,000<br><br>Total Land Area: 929 km² (359 mi²)<br><br>Province: Northern<br><br>Sri Lanka's Jaffna District occupies most of the Jaffna Peninsula in the far north and is divided into four regions: Thenmarachchi, Vadamarachchi, Valikamam, and the Jaffna Islands. The capital, Jaffna, is also the capital of the Northern Province and was once the second most populous city in Sri Lanka, though it was heavily affected by the Sri Lankan Civil War.",
    },
    11: {
      name: "Kilinochchi",
      image: "img/KilinochchiTank.webp",
      description:
        "2021 Population Estimate: 133,000<br><br>Total Land Area: 1,205 km² (465 mi²)<br><br>Province: Northern<br><br>The Kilinochchi District, located just south of Jaffna, was part of Rajarata until the 13th Century AD and later became part of the Kingdom of Jaffna. It changed hands under Portuguese, British, and Sri Lankan control, with its current borders established in 1984.",
    },
    12: {
      name: "Mannar",
      image: "img/MannarIsland.webp",
      description:
        "2021 Population Estimate: 114,000<br><br>Total Land Area: 1,880 km² (730 mi²)<br><br>Province: Northern<br><br>The Mannar District, located on Sri Lanka’s northeastern coastline and including Mannar Island, is home to unique animal and plant life, including the rare baobab trees and the marine mammal dugong, which can be found in Mannar Bay.",
    },
    13: {
      name: "Vavuniya",
      image: "img/WilpattuNationalPark.webp",
      description:
        "2021 Population Estimate: 194,000<br><br>Total Land Area: 1,861 km² (719 mi²)<br><br>Province: Northern<br><br>Vavuniya, a landlocked district in central northern Sri Lanka, borders four other districts and is part of the Northern Province. During the Sri Lankan Civil War, parts of the district were under Tamil Tigers' control but were recaptured by the Sri Lankan military in 2008.",
    },
    14: {
      name: "Mullaitivu",
      image: "img/NayaruLagoon.webp",
      description:
        "2021 Population Estimate: 92,238<br><br>Total Land Area: 2,617 km² (1,010 mi²)<br><br>Province: Northern<br><br>The Mullaitivu District, located at Sri Lanka’s northeastern tip, borders four districts and has a coastline along the Indian Ocean. During the Sri Lankan Civil War, it was under Tamil Tigers' control but was recaptured by the Sri Lankan Army in 2009. The district's capital, a fishing village, serves as an anchoring harbor for small boats transporting goods between Jaffna and Colombo.",
    },
    15: {
      name: "Anuradhapura",
      image: "img/jethawanaramasthupa.webp",
      description:
        "2021 Population Estimate: 954,000<br><br>Total Land Area: 6,664 km² (2,573 mi²)<br><br>Province: North Central<br><br>Anuradhapura, the largest district by land area in central northern Sri Lanka, borders seven other districts and has no coastline. Its capital, also named Anuradhapura, is an ancient city known for its well-preserved ruins from an ancient Sinhala civilization. A UNESCO World Heritage Site, it is one of the oldest inhabited cities in the world.",
    },
    16: {
      name: "Polonnaruwa",
      image: "img/GalVihara.webp",
      description:
        "2021 Population Estimate: 448,000<br><br>Total Land Area: 1,706 km² (659 mi²)<br><br>Province: North Central<br><br>Polonnaruwa District, one of two districts in Sri Lanka’s North Central Province, has its capital, Polonnaruwa, which is the largest city in the province. The city is divided into New Town, a modern area, and the royal ancient city of the Kingdom of Polonnaruwa.",
    },
    17: {
      name: "Trincomalee",
      image: "img/NilaveliBeach.webp",
      description:
        "2021 Population Estimate: 441,000<br><br>Total Land Area: 2,529 km² (976 mi²)<br><br>Province: Eastern<br><br>Trincomalee District, located along Sri Lanka’s northeastern coast in the Eastern Province, borders five other districts. Its capital, Trincomalee, sits on a peninsula and is a resort and port city overlooking Trincomalee Harbor. ",
    },
    18: {
      name: "Batticaloa",
      image: "img/KalkudahandPassikudah.webp",
      description:
        "2021 Population Estimate: 590,000<br><br>Total Land Area: 2,610 km² (1,010 mi²)<br><br>Province: Eastern<br><br>Batticaloa, located on Sri Lanka’s east coast, was once a larger district before part of its territory became the Ampara District in 1961. Bordered by three other districts, the capital city of Batticaloa is one of the largest in the Eastern Province. The city, once the capital of the Eastern Province, is situated on an island off the coast. Nearby, Pasikuda is a popular tourist destination with beautiful beaches and warm waters.",
    },
    19: {
      name: "Ampara",
      image: "img/GalOyaNationalPark.webp",
      description:
        "2021 Population Estimate: 752,000 <br><br> Total Land Area: 4,222 km2 (1,630 mi2) <br><br> Province: Eastern <br><br> The Ampara District is located along the southeastern coast of Sri Lanka, bordering six other districts and the Indian Ocean. It is one of the most diverse districts in the country, and it was formed in 1961 from land that had previously been a part of the Batticaloa District. During the British colonial period, the capital of Ampara was used as a resting ground for hunters.",
    },
    20: {
      name: "Puttalam",
      image: "img/Kalpitiya.webp",
      description:
        "2021 Population Estimate: 849,000<br><br>Total Land Area: 2,882 km² (1,113 mi²)<br><br>Province: North Western<br><br>Puttalam, along with Kurunegala, forms the North Western Province of Sri Lanka. Located along the western coast, it features beautiful lagoons and the Kalpitiya Peninsula. Prawn farming and shallow sea fishing are popular activities. In the district’s capital, Islam is the most widely practiced religion.",
    },
    21: {
      name: "Kurunegala",
      image: "img/EthkandaRajaMahaViharaya.webp",
      description:
        "2021 Population Estimate: 1,743,000<br><br>Total Land Area: 4,624 km² (1,785 mi²)<br><br>Province: North Western<br><br>Kurunegala District, located in Sri Lanka’s North Western Province, borders six other districts and has no coastline. The main languages spoken are Sinhalese, Tamil, and English. Kurunegala, the city and capital, is a major urban center surrounded by coconut plantations and rubber estates. The area is home to several archaeological sites, including the Royal Complex and Kurunegala Lake.",
    },
    22: {
      name: "Ratnapura",
      image: "img/sripada.webp",
      description:
        "2021 Population Estimate: 1,190,000<br><br>Total Land Area: 3,236 km² (1,249 mi²)<br><br>Province: Sabaragamuwa<br><br>Ratnapura District, located in the southern region of Sri Lanka, borders nine other districts and has no coastline. It’s a popular destination for nature lovers, offering trekking, bird-watching, and excursions into Sinharaja Forest Reserve and Udawalawe National Park. The district’s capital is known as the center for Sri Lanka's gem trade, with 'Ratnapura' meaning 'city of gems' in Sanskrit.",
    },
    23: {
      name: "Kegalle",
      image: "img/PinnawalaElephantOrphanage.webp",
      description:
        "2021 Population Estimate: 898,000<br><br>Total Land Area: 1,685 km² (651 mi²)<br><br>Province: Sabaragamuwa<br><br>Kegalle District, landlocked and located in central southern Sri Lanka, is known for rubber cultivation, the export of coffee, cocoa, and clove, and graphite mining. The history of Kegalle's capital dates back to the Stone Age, with archaeological evidence of a prospering society as far as 28,000 years ago.",
    },
    24: {
      name: "Badulla",
      image: "img/DemodaraNineArchBridge.webp",
      description:
        "2021 Population Estimate: 887,000<br><br>Total Land Area: 2,876 km² (1,111 mi²)<br><br>Province: Uva<br><br>Badulla is a picturesque district located in the central part of Sri Lanka, surrounded by mountains and tea plantations. The capital, Badulla city, is known for its historical and cultural heritage. The district is an important agricultural center, with tea, rubber, and vegetables being significant crops. Badulla is also famous for its natural beauty, including waterfalls and hiking trails.",
    },
    25: {
      name: "Monaragala",
      image: "img/RitigalaMonastery.webp",
      description:
        "2021 Population Estimate: 505,000<br><br>Total Land Area: 5,508 km² (2,127 mi²)<br><br>Province: Uva<br><br>Monaragala is the second-largest district in Sri Lanka, located in the southeast corner of the country. It borders four other districts and has no coastline. The district’s economy is largely based on agriculture, with its capital located just southeast of Badulla, approximately 170 kilometers east of Colombo.",
    },
  };

  // Click event for location links
  $(".location-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor behavior

    const districtId = $(this).data("id");
    if (districtId && districtData[districtId]) {
      const { name, image, description } = districtData[districtId];

      // Update province details dynamically
      $("#provinceName").text(name);
      $("#provinceImage").attr("src", image).attr("alt", name);
      $("#provinceDescription").html(description);

      $.get(`districts/${districtId}.txt`, function (data) {
        // Process the text data to insert images at appropriate places
        let formattedData = data;

        // Make the topics bold
        formattedData = formattedData.replace(
          /\*([^\*]+)\*/g,
          function (match, topic) {
            return `<strong class="topic">${topic}</strong>`;
          }
        );

        // Replace image markdown syntax with <img> tags
        formattedData = formattedData.replace(
          /!\[([^\]]+)\]\((img\/[a-zA-Z0-9]+\.webp)\)/g,
          function (match, altText, imgPath, index) {
            // Find the image index dynamically and alternate between left and right
            let imgClass = "district-image-left"; // Default to left alignment

            // Check if the image index is even or odd
            if (
              formattedData
                .match(/!\[[^\]]+\]\((img\/[a-zA-Z0-9]+\.webp)\)/g)
                .indexOf(match) %
                2 !==
              0
            ) {
              imgClass = "district-image-right"; // If index is odd, float right
            }

            return `<img src="${imgPath}" alt="${altText}" class="${imgClass}">`;
          }
        );

        // Insert the processed text into the HTML element
        $("#districtDescription").html(formattedData.replace(/\n/g, "<br>"));
      });
    }
  });
});
