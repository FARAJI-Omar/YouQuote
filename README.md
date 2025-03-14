YouQuote API 🌟

Project Context 📖

YouQuote is an API that allows managing quotes. It enables users to create, read, update, and delete quotes, as well as retrieve random quotes and filter them based on length. Additionally, the API tracks the popularity of the most requested quotes. 🔄

 Features 🛠️

1. Quote Management (CRUD) 📋

Users can perform the following operations on quotes:

Create a new quote ✍️

Read a specific quote 📖

Update an existing quote ✏️

Delete a quote from the database 🗑️

2. Random Quotes 🎲

The API allows users to fetch one or multiple random quotes at a time. If the count parameter is provided, multiple quotes will be fetched; otherwise, a single random quote will be returned. ✨

3. Filter Quotes by Length 📏

Users can filter quotes based on their word count. This feature allows searching for more targeted quotes based on their length. 🔍

4. Quote Popularity Tracking 📊

The API tracks and records the frequency of requests for each quote. The most requested quotes are considered popular. Every time a quote is requested, its popularity counter is incremented. 📈

Technical Requirements ⚙️

Architecture: The API is developed using Laravel with a monolithic architecture, allowing for centralized management and easy scaling. 🏗️

Database: MySQL, used to store the quotes, popularity, and user information. 🗃️

