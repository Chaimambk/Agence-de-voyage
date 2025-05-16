USE Prog_Web_Php;


INSERT INTO villes (nom, description, latitude, longitude) VALUES
                                                               ('Tokyo', 'Capitale du Japon, entre modernité et tradition.', 35.682839, 139.759455),
                                                               ('Kyoto', 'Ancienne capitale, connue pour ses temples et jardins.', 35.011636, 135.768029),
                                                               ('Osaka', 'Ville animée, célèbre pour sa cuisine et ses attractions.', 34.693737, 135.502167),
                                                               ('Hiroshima', 'Connue pour son histoire et son parc de la paix.', 34.385203, 132.455293),
                                                               ('Sapporo', 'Capitale de Hokkaido, célèbre pour son festival de la neige.', 43.0618, 141.3545),
                                                               ('Fukuoka', 'Ville portuaire dynamique avec une riche culture culinaire.', 33.5896, 130.4018),
                                                               ('Nagoya', 'Ville industrielle avec un beau château.', 35.1815, 136.9066),
                                                               ('Nara', 'Ancienne capitale avec de nombreux temples et daims en liberté.', 34.6851, 135.8048),
                                                               ('Kobe', 'Connue pour son célèbre bœuf de Kobe.', 34.6901, 135.1955),
                                                               ('Yokohama', 'Grande ville proche de Tokyo avec un port moderne.', 35.4437, 139.6380),
                                                               ('Sendai', 'Ville historique avec des festivals célèbres.', 38.2682, 140.8694),
                                                               ('Kagoshima', 'Ville volcanique avec des paysages magnifiques.', 31.5969, 130.5571),
                                                               ('Nagasaki', 'Connue pour son histoire et son port.', 32.7503, 129.8777),
                                                               ('Okinawa', 'Île tropicale avec de magnifiques plages.', 26.2124, 127.6809),
                                                               ('Hakone', 'Lieu célèbre pour ses sources thermales.', 35.2329, 139.1064),
                                                               ('Kamakura', 'Petite ville côtière avec le grand Bouddha.', 35.3192, 139.5467),
                                                               ('Takayama', 'Ville traditionnelle avec des maisons anciennes.', 36.1468, 137.2529),
                                                               ('Nikko', 'Site du temple Toshogu et nature magnifique.', 36.7198, 139.6982),
                                                               ('Fujisawa', 'Proche du Mont Fuji avec des paysages magnifiques.', 35.3389, 139.4901),
                                                               ('Matsumoto', 'Ville du célèbre château de Matsumoto.', 36.2381, 137.9716);
INSERT INTO hotels (nom, ville_id, description, image, adresse, latitude, longitude) VALUES
                                                                                         ('Hotel New Otani Tokyo', 1, 'Hôtel de luxe avec un magnifique jardin japonais.', 'otani_tokyo.jpg', '4-1 Kioicho, Tokyo', 35.6814, 139.7370),
                                                                                         ('Park Hyatt Tokyo', 1, 'Hôtel haut de gamme avec une vue spectaculaire.', 'hyatt_tokyo.jpg', '3-7-1-2 Nishi Shinjuku, Tokyo', 35.6895, 139.6917),
                                                                                         ('Ritz-Carlton Kyoto', 2, 'Un hôtel luxueux offrant une vue sur la rivière Kamo.', 'ritz_kyoto.jpg', 'Kamogawa Nijo-Ohashi, Kyoto', 35.0116, 135.7710),
                                                                                         ('Four Seasons Kyoto', 2, 'Élégant hôtel avec un beau jardin et un spa.', 'fs_kyoto.jpg', 'Higashiyama-ku, Kyoto', 35.0053, 135.7727),
                                                                                         ('Osaka Marriott Miyako Hotel', 3, 'Situé dans le plus haut gratte-ciel du Japon.', 'miyako_osaka.jpg', '1-1-43 Abenosuji, Osaka', 34.6461, 135.5139),
                                                                                         ('Hilton Osaka', 3, 'Hôtel confortable au centre-ville.', 'hilton_osaka.jpg', '8-8 Umeda, Osaka', 34.7019, 135.4945),
                                                                                         ('Sheraton Grand Hiroshima', 4, 'Proche de la gare, idéal pour visiter la ville.', 'sheraton_hiroshima.jpg', '12-1 Wakakusa, Hiroshima', 34.3965, 132.4743),
                                                                                         ('ANA Crowne Plaza Hiroshima', 4, 'Un hôtel élégant en plein cœur de la ville.', 'ana_hiroshima.jpg', '7-20 Nakamachi, Hiroshima', 34.3922, 132.4562),
                                                                                         ('Sapporo Grand Hotel', 5, 'Le plus prestigieux hôtel de Sapporo.', 'grand_sapporo.jpg', '4-chome Kita, Sapporo', 43.0642, 141.3469),
                                                                                         ('Rihga Royal Hotel Fukuoka', 6, 'Hôtel chic avec une belle vue sur la ville.', 'rihga_fukuoka.jpg', '2-14-2 Hakata Ekimae, Fukuoka', 33.5896, 130.4018);

INSERT INTO chambres (hotel_id, nom, capacite, type, prix_par_nuit, disponible) VALUES
-- Hôtel 1 : Tokyo Otani
(1, 'Chambre Simple', 1, 'adulte', 120.00, TRUE),
(1, 'Chambre Famille', 4, 'famille', 400.00, TRUE),
-- Hôtel 2 : Hyatt Tokyo
(2, 'Chambre Premium', 2, 'adulte', 250.00, TRUE),
(2, 'Chambre Famille', 4, 'famille', 450.00, TRUE),
-- Hôtel 3 : Ritz Kyoto
(3, 'Chambre Jardin', 2, 'adulte', 350.00, TRUE),
(3, 'Chambre Junior', 2, 'adulte', 200.00, TRUE),
-- Hôtel 4 : Four Seasons Kyoto
(4, 'Chambre Spa', 2, 'adulte', 500.00, TRUE),
(4, 'Chambre Tatami', 3, 'famille', 450.00, TRUE),
-- Hôtel 5 : Marriott Osaka
(5, 'Chambre Umeda', 2, 'adulte', 300.00, TRUE),
(5, 'Suite Familiale', 5, 'famille', 600.00, TRUE),
-- Hôtel 6 : Hilton Osaka
(6, 'Chambre Classique', 2, 'adulte', 220.00, TRUE),
(6, 'Suite Famille', 4, 'famille', 500.00, TRUE),
-- Hôtel 7 : Sheraton Hiroshima
(7, 'Chambre Zen', 1, 'adulte', 180.00, TRUE),
(7, 'Chambre Famille Vue Parc', 4, 'famille', 400.00, TRUE),
-- Hôtel 8 : ANA Hiroshima
(8, 'Chambre Jardin', 2, 'adulte', 260.00, TRUE),
(8, 'Suite Familiale', 5, 'famille', 550.00, TRUE),
-- Hôtel 9 : Sapporo Grand Hotel
(9, 'Chambre Neige', 2, 'adulte', 280.00, TRUE),
(9, 'Suite Grand Nord', 3, 'famille', 500.00, TRUE),
-- Hôtel 10 : Rihga Fukuoka
(10, 'Chambre Hakata', 2, 'adulte', 230.00, TRUE),
(10, 'Suite Vue Port', 3, 'adulte', 450.00, TRUE),
(10, 'Chambre Enfants', 2, 'enfant', 120.00, TRUE),
-- Extra pour variation de disponibilité
(2, 'Chambre temporairement non dispo', 2, 'adulte', 180.00, FALSE),
(5, 'Suite Deluxe Occupée', 2, 'adulte', 600.00, FALSE),
(9, 'Chambre Économique', 1, 'adulte', 100.00, TRUE),
(10, 'Chambre Business', 1, 'adulte', 160.00, TRUE);




INSERT INTO activites (ville_id, nom, description, prix, image) VALUES
                                                                    (1, 'Visite de la Tour de Tokyo', 'Vue panoramique incroyable.', 20.00, 'tokyo_tower.jpg'),
                                                                    (1, 'Excursion à Akihabara', 'Découverte du quartier geek.', 15.00, 'akihabara.jpg'),
                                                                    (2, 'Balade en kimono à Kyoto', 'Expérience traditionnelle unique.', 40.00, 'kimono_kyoto.jpg'),
                                                                    (2, 'Cérémonie du thé', 'Initiation à la cérémonie du thé.', 25.00, 'tea_kyoto.jpg'),
                                                                    (3, 'Dégustation de street food à Osaka', 'Essayez les fameux Takoyaki.', 15.00, 'takoyaki_osaka.jpg'),
                                                                    (3, 'Visite du Château d’Osaka', 'Plongée dans l’histoire du Japon.', 30.00, 'osaka_castle.jpg'),
                                                                    (4, 'Mémorial de la Paix de Hiroshima', 'Hommage historique et culturel.', 0.00, 'peace_hiroshima.jpg'),
                                                                    (5, 'Festival de la neige à Sapporo', 'Sculptez votre propre statue de glace.', 50.00, 'sapporo_snow.jpg');
