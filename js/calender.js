const monthsData = [
    {
        month: "January",
        specialty: "January marks the beginning of the dry season in Sri Lanka, making it an excellent time to explore the island's cultural heritage and natural beauty without the interruption of heavy rains.",
        festivals: "Thai Pongal, celebrated predominantly by the Tamil community, is a colorful harvest festival filled with traditional rituals and feasting.",
        bestCities: "Colombo, the vibrant capital city, offers a blend of modern attractions and historical sites. Anuradhapura, an ancient city rich in cultural heritage, is perfect for exploring historical ruins.",
        img: "img/calender1.webp"
    },
    {
        month: "February",
        specialty: "February is a good time to visit Sri Lanka's central and southern regions, with less rainfall and cooler temperatures.",
        festivals: "The Buddhist festival of Maha Shivaratri is observed in Sri Lanka, particularly among Tamil communities.",
        bestCities: "Kandy, a city filled with cultural significance, and Galle, known for its colonial architecture and beaches, are great to visit in February.",
        img: "img/calender2.webp"
    },
    {
        month: "March",
        specialty: "March marks the transition from the dry season to the rainy season. The weather is warm and perfect for exploring Sri Lanka's beaches and coastal cities.",
        festivals: "The Sinhala and Tamil New Year is celebrated in April, but preparations begin in March with various cultural events.",
        bestCities: "Negombo, a coastal city known for its beautiful beaches, and Colombo, with its vibrant urban culture, are great choices for March.",
        img: "img/calender3.webp"
    },
    {
        month: "April",
        specialty: "April is when Sri Lanka celebrates its New Year, marking the end of the harvest season and the beginning of the rains.",
        festivals: "Sinhala and Tamil New Year, celebrated with traditional rituals, games, and feasting, is the major festival of the month.",
        bestCities: "Kandy, with its scenic beauty and cultural importance, and Colombo, for a mix of old and new, are the best cities to visit in April.",
        img: "img/calender4.webp"
    },
    {
        month: "May",
        specialty: "May is the start of the southwest monsoon season, making it a good time to visit the eastern and northern parts of Sri Lanka where the weather remains dry.",
        festivals: "Vesak, celebrating the birth, enlightenment, and death of Buddha, is one of the most significant Buddhist festivals in Sri Lanka.",
        bestCities: "Trincomalee, a beautiful coastal town in the east, and Anuradhapura, an ancient city, are ideal to visit during May.",
        img: "img/calender5.webp"
    },
    {
        month: "June",
        specialty: "June is part of the monsoon season in Sri Lanka, and it is best to explore the eastern and northern regions where the weather is still dry.",
        festivals: "The Poson festival, commemorating the arrival of Buddhism in Sri Lanka, is celebrated in June.",
        bestCities: "Jaffna, a city rich in history, and Trincomalee, known for its beaches, are recommended in June.",
        img: "img/calender6.webp"
    },
    {
        month: "July",
        specialty: "July is a warm month with occasional rain in some parts of the island. The cultural and religious festivals add vibrancy to the atmosphere.",
        festivals: "Esala Perahera, one of Sri Lanka's most famous cultural festivals, takes place in Kandy in July.",
        bestCities: "Kandy, during the Esala Perahera, and Galle, with its colonial heritage, are the top cities to visit in July.",
        img: "img/calender7.webp"
    },
    {
        month: "August",
        specialty: "August is part of the southwest monsoon season, making it a good time to explore the dry regions of Sri Lanka.",
        festivals: "The Kandy Esala Perahera continues through the month, showcasing a stunning display of culture and tradition.",
        bestCities: "Kandy, during the festival, and Colombo, with its bustling urban life, are great choices for August.",
        img: "img/calender8.webp"
    },
    {
        month: "September",
        specialty: "September is the end of the southwest monsoon season, and the weather is great for exploring the central and southern regions of Sri Lanka.",
        festivals: "The Full Moon Poya day, celebrating important events in the life of Buddha, is observed in September.",
        bestCities: "Ella, known for its scenic beauty and hiking trails, and Colombo, a modern hub, are recommended for September.",
        img: "img/calender9.webp"
    },
    {
        month: "October",
        specialty: "October marks the end of the monsoon season, making it a perfect time for outdoor activities and exploring the cultural heart of Sri Lanka.",
        festivals: "The Navaratri festival, a Hindu festival dedicated to the goddess Durga, is observed in Sri Lanka in October.",
        bestCities: "Kandy, for its cultural experiences, and Nuwara Eliya, with its cool climate and tea plantations, are ideal to visit in October.",
        img: "img/calender10.webp"
    },
    {
        month: "November",
        specialty: "November sees the start of the northeast monsoon season, with rain in the northern and eastern parts of the island, but it is still a great time for the beaches on the western side.",
        festivals: "Deepavali, the Hindu festival of lights, is widely celebrated in Sri Lanka in November.",
        bestCities: "Galle, for its coastal beauty, and Colombo, for its blend of history and modern attractions, are recommended for November.",
        img: "img/calender11.webp"
    },
    {
        month: "December",
        specialty: "December is the beginning of the peak tourist season in Sri Lanka, with excellent weather conditions for traveling around the island.",
        festivals: "Christmas is celebrated by the Christian community, and the New Year celebrations begin in December.",
        bestCities: "Colombo, for its vibrant city life, and Nuwara Eliya, with its cool climate, are great choices for December.",
        img: "img/calender12.webp"
    }
];

const monthIcons = {
    January: "fas fa-sun",
    February: "fas fa-snowflake",
    March: "fas fa-wind",
    April: "fas fa-leaf",
    May: "fas fa-cloud-sun",
    June: "fas fa-cloud-showers-heavy",
    July: "fas fa-cloud-sun-rain",
    August: "fas fa-cloud-sun-rain",
    September: "fas fa-sun",
    October: "fas fa-tree",
    November: "fas fa-cloud",
    December: "fas fa-snowman"
};

let currentIndex = 0;

function showMonthContent(index) {
    const month = monthsData[index];
    document.getElementById("monthImage").src = month.img;
    const monthContent = `
        <h2>${month.month}</h2>
        <h5>Specialty</h5>
        <p>${month.specialty}</p>
        <h5>Festivals</h5>
        <p>${month.festivals}</p>
        <h5>Best Cities</h5>
        <p>${month.bestCities}</p>
    `;
    document.getElementById("monthContent").innerHTML = monthContent;
}

function createCalendarView() {
    const calendarGrid = document.getElementById("calendarGrid");
    monthsData.forEach((month, index) => {
        const cell = document.createElement("div");
        cell.className = "calendar-cell";
        cell.innerHTML = `<strong>${month.month}</strong>`;
        cell.addEventListener("click", () => {
            document.querySelectorAll('.calendar-cell').forEach(c => c.classList.remove('selected'));
            cell.classList.add('selected');
            showMonthContent(index);
        });
        if (index === 0) {
            cell.classList.add('selected');
            showMonthContent(index);
        }
        calendarGrid.appendChild(cell);
    });
}

createCalendarView();
showMonthContent(currentIndex);