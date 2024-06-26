-- Users
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('John Doe', 'johndoe@example.com', '1234567890', 'N', '5f4dcc3b5aa765d61d8327deb882cf99');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Jane Smith', 'janesmith@example.com', '0987654321', 'Y', '7c6a180b36896a0a8c02787eeafb0e4c');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Mike Johnson', 'mikejohnson@example.com', '1122334455', 'N', 'e99a18c428cb38d5f260853678922e03');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Emily Davis', 'emilydavis@example.com', '2233445566', 'N', 'aab3238922bcc25a6f606eb525ffdc56');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Chris Brown', 'chrisbrown@example.com', '3344556677', 'Y', '25f9e794323b453885f5181f1b624d0b');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Jessica Taylor', 'jessicataylor@example.com', '4455667788', 'N', 'e0c9035898dd52fc65c41454cec9c4d8');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Robert Wilson', 'robertwilson@example.com', '5566778899', 'N', '5ebe2294ecd0e0f08eab7690d2a6ee69');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Sarah Miller', 'sarahmiller@example.com', '6677889900', 'Y', '8f14e45fceea167a5a36dedd4bea2543');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Brian Moore', 'brianmoore@example.com', '7788990011', 'N', 'ae2b1fca515949e5d54fb22b8ed95575');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Laura Jackson', 'laurajackson@example.com', '8899001122', 'N', '7e58d63b60197ceb55a1c487989a3720');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('David White', 'davidwhite@example.com', '9900112233', 'Y', '25d55ad283aa400af464c76d713c07ad');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Angela Harris', 'angelaharris@example.com', '1231231234', 'N', '1702a132e769a623c1adb78353fc9503');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Thomas Clark', 'thomasclark@example.com', '2342342345', 'N', '6cb75f652a9b52798eb6cf2201057c73');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Sandra Rodriguez', 'sandrarodriguez@example.com', '3453453456', 'Y', '9bf31c7ff062936a96d3c8bd1f8f2ff3');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Kevin Lewis', 'kevinlewis@example.com', '4564564567', 'N', 'e2c420d928d4bf8ce0ff2ec19b371514');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Jessica Walker', 'jessicawalker@example.com', '5675675678', 'N', '3a3ea00cfc35332cedf6e5e9a32e94da');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('George Allen', 'georgeallen@example.com', '6786786789', 'Y', '5f93f983524def3dca464469d2cf9f3e');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Nancy Young', 'nancyyoung@example.com', '7897897890', 'N', '60c618e69491504b0a7b81a77cd15a15');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Edward King', 'edwardking@example.com', '8908908901', 'N', '57cec4137b614c87cb4e24a3d003a3e0');
INSERT INTO Users (Name, Email, PhoneNumber, IsAdmin, PasswordHash) VALUES ('Lisa Wright', 'lisawright@example.com', '9019019012', 'Y', '4a8a08f09d37b73795649038408b5f33');

-- Categories
INSERT INTO Categories (Name) VALUES ('Smartphones and Accessories');
INSERT INTO Categories (Name) VALUES ('Computers and Laptops');
INSERT INTO Categories (Name) VALUES ('Tablets and E-readers');
INSERT INTO Categories (Name) VALUES ('Wearables');
INSERT INTO Categories (Name) VALUES ('Gaming Consoles and Accessories');
INSERT INTO Categories (Name) VALUES ('Cameras and Photography');
INSERT INTO Categories (Name) VALUES ('Audio and Headphones');
INSERT INTO Categories (Name) VALUES ('Smart Home Devices');
INSERT INTO Categories (Name) VALUES ('Drones and Robotics');
INSERT INTO Categories (Name) VALUES ('Networking and WiFi');
INSERT INTO Categories (Name) VALUES ('Printers and Scanners');
INSERT INTO Categories (Name) VALUES ('Software');
INSERT INTO Categories (Name) VALUES ('TVs and Monitors');
INSERT INTO Categories (Name) VALUES ('Home Theater and Audio');
INSERT INTO Categories (Name) VALUES ('Chargers, Batteries and Power Supplies');
INSERT INTO Categories (Name) VALUES ('Cables and Connectors');
INSERT INTO Categories (Name) VALUES ('Storage and Hard Drives');
INSERT INTO Categories (Name) VALUES ('Components and Parts');
INSERT INTO Categories (Name) VALUES ('Office Electronics');
INSERT INTO Categories (Name) VALUES ('Car Electronics and GPS');
INSERT INTO Categories (Name) VALUES ('Virtual Reality (VR) and Augmented Reality (AR) Devices');
INSERT INTO Categories (Name) VALUES ('Electric Vehicles and Accessories');
INSERT INTO Categories (Name) VALUES ('Health and Fitness Gadgets');
INSERT INTO Categories (Name) VALUES ('Educational Tech and Toys');
INSERT INTO Categories (Name) VALUES ('Portable Power Generators and Solar Panels');

-- Products
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('XPhone 12', 799.99, 'Latest model with 5G connectivity and 128GB storage.', 1);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SmartCase Pro', 59.99, 'Water-resistant and drop-proof case.', 1);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('LapTop Pro 15', 1200.00, '15 inches, 16GB RAM, 512GB SSD, 8-core processor.', 2);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('DeskFast Station', 1800.00, '32GB RAM, 1TB SSD, 12-core processor, includes monitor.', 2);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('ReadLite E-reader', 150.00, '8-inch display, waterproof, 32GB storage.', 3);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('TabView S8', 650.00, '12-inch display, 128GB storage, stylus included.', 3);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SoundBlast Headphones', 250.00, 'Noise cancelling, wireless, 20 hours battery life.', 7);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('BassKing Earbuds', 129.99, 'True wireless, waterproof, touch controls, 12 hours playtime.', 7);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SmartLight Bulb', 20.99, 'RGB color, Wi-Fi connected, app-controlled.', 8);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('HomeGuard Security Cam', 180.00, '1080p HD, night vision, motion alerts, Wi-Fi.', 8);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('UltraNet Mesh Router', 299.99, 'Tri-band Wi-Fi 6 system, covers 6000 sq ft.', 10);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SpeedStream WiFi Extender', 89.99, 'Extend Wi-Fi range, supports Wi-Fi 6, easy setup.', 10);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('XCharge Wireless Charger', 39.99, 'Fast wireless charging pad with 10W power.', 1);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('GamerMax Keyboard', 99.99, 'Mechanical keyboard with customizable RGB lighting.', 2);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('FitTrack Dara', 89.99, 'Smart scale with body composition and health metrics.', 4);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('GameMaster Controller', 59.99, 'Ergonomic design, wireless, with haptic feedback.', 5);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('DreamView VR Headset', 299.99, 'Immersive VR gaming headset with 110° field of view.', 21);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('EcoDrive E-Scooter', 450.00, 'Electric scooter with 15-mile range and 15 mph top speed.', 22);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('HeartBeat Fitness Tracker', 149.99, '24/7 heart rate monitoring, GPS, water-resistant.', 23);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('CodeMaster Programming Game', 29.99, 'Teaches programming fundamentals through fun gameplay.', 24);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SunPower Portable Generator', 199.99, 'Portable power station for camping and emergencies.', 25);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('ClearView Phone Stand', 15.99, 'Adjustable angle, compatible with all smartphones.', 1);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('UltraProtect Screen Protector', 9.99, 'Tempered glass, scratch-resistant, for XPhone 12.', 1);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('ProGraphics Design Tablet', 299.99, 'High precision, 2048 pressure levels, for designers.', 2);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('MultiSync Bluetooth Keyboard', 49.99, 'Connect up to 3 devices, compact layout.', 2);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('FlexCover for ReadLite', 29.99, 'Durable, slim protection with stand feature.', 3);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('TabView Keyboard Case', 69.99, 'Integrated keyboard for productivity, protective cover.', 3);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('EchoSound Portable Speaker', 59.99, 'Waterproof, Bluetooth, 24 hours playtime.', 7);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('QuietTune ANC Headphones', 329.99, 'Advanced active noise cancellation, over-ear.', 7);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('TempSmart Thermostat', 199.99, 'Wi-Fi enabled, smart home integration, energy saving.', 8);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('BrightHome Smart Lights Pack', 49.99, '4-pack, voice-controlled, customizable colors.', 8);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('ARExplorer Glasses', 499.99, 'Augmented reality experiences, lightweight design.', 21);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('VirtualSpace Gaming Set', 799.99, 'Complete VR kit for immersive gaming, includes controllers.', 21);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('VoltCharge EV Charging Station', 599.99, 'Home electric vehicle charging, fast charge.', 22);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('EcoTire Inflator', 49.99, 'Portable, for bikes and scooters, digital pressure gauge.', 22);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SmartYoga Mat', 99.99, 'Integrated with pose detection, feedback through app.', 23);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('AquaPulse Water Bottle', 29.99, 'Tracks water intake, syncs with fitness trackers.', 23);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('BuildABot Robotics Kit', 99.99, 'Learn to build and program robots, age 8+.', 24);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('SkyGazer 3000 Telescope', 249.99, 'App-enabled, for beginners and young astronomers.', 24);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('EcoSolar Panel Kit', 399.99, '100W, portable, for outdoor and emergency power.', 25);
INSERT INTO Products (Name, Price, Description, CategoryID) VALUES ('AdventurePower Solar Charger', 59.99, 'Compact, foldable, ideal for hiking and camping.', 25);

-- Cart
INSERT INTO Cart (UserID) VALUES (1);
INSERT INTO Cart (UserID) VALUES (2);
INSERT INTO Cart (UserID) VALUES (3);
INSERT INTO Cart (UserID) VALUES (4);
INSERT INTO Cart (UserID) VALUES (5);
INSERT INTO Cart (UserID) VALUES (6);
INSERT INTO Cart (UserID) VALUES (7);
INSERT INTO Cart (UserID) VALUES (8);
INSERT INTO Cart (UserID) VALUES (9);
INSERT INTO Cart (UserID) VALUES (10);
INSERT INTO Cart (UserID) VALUES (11);
INSERT INTO Cart (UserID) VALUES (12);
INSERT INTO Cart (UserID) VALUES (13);
INSERT INTO Cart (UserID) VALUES (14);
INSERT INTO Cart (UserID) VALUES (15);
INSERT INTO Cart (UserID) VALUES (16);
INSERT INTO Cart (UserID) VALUES (17);
INSERT INTO Cart (UserID) VALUES (18);
INSERT INTO Cart (UserID) VALUES (19);
INSERT INTO Cart (UserID) VALUES (20);

-- CartItems
INSERT INTO CartItems (CartID, ProductID) VALUES (1, 1);
INSERT INTO CartItems (CartID, ProductID) VALUES (1, 2);
INSERT INTO CartItems (CartID, ProductID) VALUES (2, 3);
INSERT INTO CartItems (CartID, ProductID) VALUES (2, 4);
INSERT INTO CartItems (CartID, ProductID) VALUES (3, 5);
INSERT INTO CartItems (CartID, ProductID) VALUES (3, 6);
INSERT INTO CartItems (CartID, ProductID) VALUES (4, 7);
INSERT INTO CartItems (CartID, ProductID) VALUES (4, 8);
INSERT INTO CartItems (CartID, ProductID) VALUES (5, 9);
INSERT INTO CartItems (CartID, ProductID) VALUES (5, 10);
INSERT INTO CartItems (CartID, ProductID) VALUES (6, 11);
INSERT INTO CartItems (CartID, ProductID) VALUES (6, 12);
INSERT INTO CartItems (CartID, ProductID) VALUES (7, 1);
INSERT INTO CartItems (CartID, ProductID) VALUES (7, 2);
INSERT INTO CartItems (CartID, ProductID) VALUES (8, 3);
INSERT INTO CartItems (CartID, ProductID) VALUES (8, 4);
INSERT INTO CartItems (CartID, ProductID) VALUES (9, 5);
INSERT INTO CartItems (CartID, ProductID) VALUES (9, 6);
INSERT INTO CartItems (CartID, ProductID) VALUES (10, 7);
INSERT INTO CartItems (CartID, ProductID) VALUES (10, 8);

-- Orders
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (1, 500.00, 'Credit Card', 10101, 'City A', 'Address 1');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (2, 1200.50, 'PayPal', 20202, 'City B', 'Address 2');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (3, 750.99, 'Debit Card', 30303, 'City C', 'Address 3');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (4, 300.00, 'Credit Card', 40404, 'City D', 'Address 4');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (5, 1999.99, 'Bank Transfer', 50505, 'City E', 'Address 5');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (6, 450.00, 'Credit Card', 60606, 'City F', 'Address 6');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (7, 99.99, 'PayPal', 70707, 'City G', 'Address 7');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (8, 850.75, 'Debit Card', 80808, 'City H', 'Address 8');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (9, 220.00, 'Credit Card', 90909, 'City I', 'Address 9');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (10, 599.99, 'Bank Transfer', 10010, 'City J', 'Address 10');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (11, 320.00, 'Credit Card', 11111, 'City K', 'Address 11');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (12, 1000.00, 'PayPal', 12121, 'City L', 'Address 12');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (13, 780.00, 'Debit Card', 13131, 'City M', 'Address 13');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (14, 450.50, 'Credit Card', 14141, 'City N', 'Address 14');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (15, 1300.99, 'Bank Transfer', 15151, 'City O', 'Address 15');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (16, 550.00, 'Credit Card', 16161, 'City P', 'Address 16');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (17, 80.99, 'PayPal', 17171, 'City Q', 'Address 17');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (18, 900.00, 'Debit Card', 18181, 'City R', 'Address 18');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (19, 250.00, 'Credit Card', 19191, 'City S', 'Address 19');
INSERT INTO SYSTEM.ORDERS (USERID, TOTALAMOUNT, PAYMENTMETHOD, ZIPCODE, CITY, ADDRESS) VALUES (20, 650.49, 'Bank Transfer', 20202, 'City T', 'Address 20');

-- Reviews
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (1, 1, 5, 'Excellent product, highly recommend!');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (2, 2, 4, 'Very good, but the battery life could be better.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (3, 3, 3, 'Average, not what I expected but works fine.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (4, 4, 5, 'Outstanding quality, would buy again.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (5, 5, 2, 'Not satisfied, product stopped working after a week.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (6, 6, 4, 'Good value for the price.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (7, 7, 5, 'Exceeds expectations, fantastic purchase.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (8, 8, 1, 'Poor build quality, would not recommend.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (9, 9, 3, 'It’s okay, but I had some issues with installation.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (10, 10, 4, 'Really good, only minor complaints.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (11, 1, 5, 'Amazing performance, beyond my expectations.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (12, 2, 2, 'Battery life is disappointing for the price.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (13, 3, 4, 'Decent product, has been working well so far.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (14, 4, 1, 'Stopped working after a month, not happy.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (15, 5, 3, 'Average quality, you get what you pay for.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (16, 6, 4, 'Pretty good, but I expected more features.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (17, 7, 5, 'Top-notch product, will recommend to everyone.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (18, 8, 2, 'Not worth the price, very basic features.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (19, 9, 4, 'Works well, but the setup was complicated.');
INSERT INTO Reviews (UserID, ProductID, Rating, Text) VALUES (20, 10, 5, 'I love this product, it’s been fantastic!');

-- Coupons
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('WELCOME10', 10.00, 1);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('SPRING20', 20.00, 2);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('SUMMER15', 15.00, 3);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('FALL10', 10.00, 4);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('WINTER20', 20.00, 5);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('VIPCUSTOMER', 25.00, 6);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('BLACKFRIDAY30', 30.00, 7);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('CYBERMONDAY25', 25.00, 8);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('HAPPY2024', 20.24, 9);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('10OFF', 10.00, 10);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('20OFF', 20.00, 11);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('FIRSTBUY5', 5.00, 12);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('STUDENT10', 10.00, 13);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('TECHLOVE15', 15.00, 14);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('GADGETGURU10', 10.00, 15);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('NEWYEAR20', 20.00, 16);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('EASTER15', 15.00, 17);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('THANKYOU10', 10.00, 18);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('BIRTHDAY20', 20.00, 19);
INSERT INTO Coupons (Code, Discount, UserID) VALUES ('ANNIVERSARY15', 15.00, 20);