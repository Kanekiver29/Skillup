<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // 21ST CENTURY SKILLS
            [
                'title' => 'Critical Thinking and Problem Solving',
                'category' => '21st Century Skills',
                'level' => 'Beginner',
                'duration_hours' => 30,
                'instructor_name' => 'Dr. James Peterson',
                'instructor_title' => 'Education Specialist',
                'image_url' => 'images/courses/critical-thinking.jpg',
                'rating' => 4.7,
                'students_count' => 5200,
                'short_description' => 'Develop critical thinking and problem-solving skills essential in the modern workplace.',
                'description' => 'Master the skills of critical thinking and problem-solving. Learn frameworks for analyzing complex problems, evaluating information, and developing innovative solutions. Perfect for professionals in any field.',
                'lessons' => [
                    [
                        'title' => 'Introduction to Critical Thinking',
                        'description' => 'Understand what critical thinking is and why it matters.',
                        'duration_minutes' => 45,
                        'content' => 'Explore the fundamentals of critical thinking and its applications.',
                    ],
                    [
                        'title' => 'Problem-Solving Frameworks',
                        'description' => 'Learn structured approaches to solving problems.',
                        'duration_minutes' => 60,
                        'content' => 'Discover proven problem-solving methodologies used by successful organizations.',
                    ],
                ]
            ],
            [
                'title' => 'Digital Communication and Collaboration',
                'category' => '21st Century Skills',
                'level' => 'Beginner',
                'duration_hours' => 25,
                'instructor_name' => 'Lisa Chen',
                'instructor_title' => 'Communication Expert',
                'image_url' => 'images/courses/digital-communication.jpg',
                'rating' => 4.8,
                'students_count' => 7300,
                'short_description' => 'Learn effective digital communication and team collaboration skills for the modern workplace.',
                'description' => 'Master digital communication tools and collaborative techniques. Learn how to communicate effectively in virtual environments and work seamlessly with remote teams.',
                'lessons' => [
                    [
                        'title' => 'Virtual Communication Essentials',
                        'description' => 'Best practices for digital communication.',
                        'duration_minutes' => 55,
                        'content' => 'Learn how to communicate effectively using digital tools.',
                    ],
                    [
                        'title' => 'Team Collaboration Tools',
                        'description' => 'Master tools for team collaboration.',
                        'duration_minutes' => 50,
                        'content' => 'Explore popular collaboration platforms and best practices.',
                    ],
                ]
            ],
            [
                'title' => 'Creativity and Innovation',
                'category' => '21st Century Skills',
                'level' => 'Intermediate',
                'duration_hours' => 35,
                'instructor_name' => 'Michael Torres',
                'instructor_title' => 'Innovation Consultant',
                'image_url' => 'images/courses/creativity-innovation.jpg',
                'rating' => 4.6,
                'students_count' => 4500,
                'short_description' => 'Unlock your creative potential and learn to innovate in any industry.',
                'description' => 'Develop creative thinking abilities and learn innovation methodologies. Learn how to generate ideas, think outside the box, and drive innovative change in organizations.',
                'lessons' => [
                    [
                        'title' => 'Creative Thinking Techniques',
                        'description' => 'Brainstorming and ideation methods.',
                        'duration_minutes' => 65,
                        'content' => 'Learn proven techniques for generating creative ideas.',
                    ],
                ]
            ],

            // AGRICULTURE
            [
                'title' => 'Sustainable Farming Practices',
                'category' => 'Agriculture',
                'level' => 'Beginner',
                'duration_hours' => 45,
                'instructor_name' => 'Robert Martinez',
                'instructor_title' => 'Agricultural Specialist',
                'rating' => 4.5,
                'students_count' => 3200,
                'short_description' => 'Learn sustainable farming techniques for better crop yields and environmental protection.',
                'description' => 'Master sustainable agricultural practices including crop rotation, soil management, and organic farming methods. Learn how to maximize yields while protecting the environment.',
                'lessons' => [
                    [
                        'title' => 'Soil Management Fundamentals',
                        'description' => 'Understand soil health and management.',
                        'duration_minutes' => 70,
                        'content' => 'Learn about soil composition, pH levels, and nutrient management.',
                    ],
                    [
                        'title' => 'Crop Rotation and Pest Management',
                        'description' => 'Sustainable approaches to manage pests.',
                        'duration_minutes' => 75,
                        'content' => 'Explore natural pest control and crop rotation strategies.',
                    ],
                ]
            ],
            [
                'title' => 'Precision Agriculture and Technology',
                'category' => 'Agriculture',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Dr. Susan Park',
                'instructor_title' => 'Agritech Expert',
                'rating' => 4.7,
                'students_count' => 2800,
                'short_description' => 'Learn how to use modern technology to improve agricultural productivity.',
                'description' => 'Discover precision agriculture technologies including drones, sensors, and data analytics for optimizing crop management and maximizing returns.',
                'lessons' => [
                    [
                        'title' => 'IoT and Sensors in Agriculture',
                        'description' => 'Smart farm monitoring systems.',
                        'duration_minutes' => 60,
                        'content' => 'Learn about sensor technology for real-time farm monitoring.',
                    ],
                ]
            ],

            // AUTOMOTIVE AND LAND TRANSPORT
            [
                'title' => 'Automotive Maintenance and Repair',
                'category' => 'Automotive and Land Transport',
                'level' => 'Intermediate',
                'duration_hours' => 50,
                'instructor_name' => 'David Johnson',
                'instructor_title' => 'Master Mechanic',
                'rating' => 4.6,
                'students_count' => 4100,
                'short_description' => 'Learn vehicle maintenance, diagnostics, and repair skills.',
                'description' => 'Master automotive troubleshooting and repair techniques. Learn about engine diagnostics, electrical systems, and modern vehicle maintenance best practices.',
                'lessons' => [
                    [
                        'title' => 'Basic Engine Maintenance',
                        'description' => 'Essential engine care and maintenance.',
                        'duration_minutes' => 75,
                        'content' => 'Learn routine maintenance tasks and engine diagnostics.',
                    ],
                    [
                        'title' => 'Electrical Systems and Diagnostics',
                        'description' => 'Understanding automotive electrical systems.',
                        'duration_minutes' => 80,
                        'content' => 'Master vehicle electrical systems and diagnostic tools.',
                    ],
                ]
            ],
            [
                'title' => 'Electric Vehicle Technology',
                'category' => 'Automotive and Land Transport',
                'level' => 'Advanced',
                'duration_hours' => 55,
                'instructor_name' => 'Alex Green',
                'instructor_title' => 'EV Specialist',
                'rating' => 4.8,
                'students_count' => 3700,
                'short_description' => 'Understand the future of transportation with electric vehicle technology.',
                'description' => 'Explore electric vehicle technology, battery systems, charging infrastructure, and the future of sustainable transportation.',
                'lessons' => [
                    [
                        'title' => 'EV Battery Technology',
                        'description' => 'Understanding lithium-ion and advanced batteries.',
                        'duration_minutes' => 85,
                        'content' => 'Learn about EV battery systems, performance, and maintenance.',
                    ],
                ]
            ],

            // CONSTRUCTION
            [
                'title' => 'Construction Management Essentials',
                'category' => 'Construction',
                'level' => 'Intermediate',
                'duration_hours' => 45,
                'instructor_name' => 'Thomas Wilson',
                'instructor_title' => 'Project Manager',
                'rating' => 4.5,
                'students_count' => 2900,
                'short_description' => 'Learn construction project management and site supervision.',
                'description' => 'Master construction management principles including project planning, budgeting, scheduling, and team coordination for successful project delivery.',
                'lessons' => [
                    [
                        'title' => 'Project Planning and Scheduling',
                        'description' => 'Effective construction scheduling methods.',
                        'duration_minutes' => 65,
                        'content' => 'Learn Gantt charts, critical path analysis, and project timelines.',
                    ],
                ]
            ],
            [
                'title' => 'Building Information Modeling (BIM)',
                'category' => 'Construction',
                'level' => 'Advanced',
                'duration_hours' => 50,
                'instructor_name' => 'Sophia Rodriguez',
                'instructor_title' => 'BIM Specialist',
                'rating' => 4.7,
                'students_count' => 2200,
                'short_description' => 'Master modern BIM technology for construction planning and execution.',
                'description' => 'Learn Building Information Modeling using industry-standard tools. Understand 3D modeling, collaboration, and data management for modern construction projects.',
                'lessons' => [
                    [
                        'title' => 'Introduction to BIM',
                        'description' => 'Basics of Building Information Modeling.',
                        'duration_minutes' => 70,
                        'content' => 'Understand BIM concepts and benefits in construction.',
                    ],
                ]
            ],

            // ELECTRICAL AND ELECTRONICS
            [
                'title' => 'Electrical Wiring and Installation',
                'category' => 'Electrical and Electronics',
                'level' => 'Intermediate',
                'duration_hours' => 48,
                'instructor_name' => 'George Adams',
                'instructor_title' => 'Licensed Electrician',
                'rating' => 4.6,
                'students_count' => 3500,
                'short_description' => 'Learn safe electrical wiring installation and best practices.',
                'description' => 'Master electrical safety codes, wiring methods, and installation techniques. Learn to install residential and commercial electrical systems safely and efficiently.',
                'lessons' => [
                    [
                        'title' => 'Electrical Safety and Codes',
                        'description' => 'Understanding electrical safety standards.',
                        'duration_minutes' => 60,
                        'content' => 'Learn electrical codes and safety practices.',
                    ],
                    [
                        'title' => 'Wiring Installation Techniques',
                        'description' => 'Safe and efficient wiring methods.',
                        'duration_minutes' => 75,
                        'content' => 'Master residential and commercial wiring techniques.',
                    ],
                ]
            ],
            [
                'title' => 'Electronics and Circuit Design',
                'category' => 'Electrical and Electronics',
                'level' => 'Intermediate',
                'duration_hours' => 52,
                'instructor_name' => 'Dr. Raj Patel',
                'instructor_title' => 'Electronics Engineer',
                'rating' => 4.8,
                'students_count' => 4300,
                'short_description' => 'Learn electronic components, circuits, and design principles.',
                'description' => 'Understand electronic components, circuit analysis, and design methodologies. Learn about resistors, capacitors, transistors, and how to design functional electronic circuits.',
                'lessons' => [
                    [
                        'title' => 'Electronic Components Basics',
                        'description' => 'Understanding passive and active components.',
                        'duration_minutes' => 70,
                        'content' => 'Learn about resistors, capacitors, diodes, transistors, and more.',
                    ],
                ]
            ],
            [
                'title' => 'Renewable Energy Technologies',
                'category' => 'Electrical and Electronics',
                'level' => 'Advanced',
                'duration_hours' => 55,
                'instructor_name' => 'Emma Watson',
                'instructor_title' => 'Energy Systems Engineer',
                'rating' => 4.9,
                'students_count' => 3900,
                'short_description' => 'Learn about solar, wind, and other renewable energy systems.',
                'description' => 'Explore renewable energy technologies including solar panels, wind turbines, and battery storage systems. Learn installation, maintenance, and system design.',
                'lessons' => [
                    [
                        'title' => 'Solar Energy Systems',
                        'description' => 'Photovoltaic systems and solar installation.',
                        'duration_minutes' => 85,
                        'content' => 'Learn how solar panels work and system design principles.',
                    ],
                ]
            ],

            // ENTREPRENEURSHIP
            [
                'title' => 'Startup Fundamentals and Business Planning',
                'category' => 'Entrepreneurship',
                'level' => 'Beginner',
                'duration_hours' => 35,
                'instructor_name' => 'Jennifer Brooks',
                'instructor_title' => 'Serial Entrepreneur',
                'rating' => 4.7,
                'students_count' => 6800,
                'short_description' => 'Learn how to start and plan your own business venture.',
                'description' => 'Master business planning, market research, and startup essentials. Learn how to validate ideas, create business plans, and prepare for launch.',
                'lessons' => [
                    [
                        'title' => 'Business Idea Validation',
                        'description' => 'Testing and validating business ideas.',
                        'duration_minutes' => 55,
                        'content' => 'Learn methods to validate your business concept.',
                    ],
                    [
                        'title' => 'Creating a Business Plan',
                        'description' => 'Writing effective business plans.',
                        'duration_minutes' => 65,
                        'content' => 'Understand components of a winning business plan.',
                    ],
                ]
            ],
            [
                'title' => 'Small Business Management and Growth',
                'category' => 'Entrepreneurship',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Marcus Stone',
                'instructor_title' => 'Business Coach',
                'rating' => 4.6,
                'students_count' => 5300,
                'short_description' => 'Learn how to manage and scale your small business.',
                'description' => 'Master small business operations, financial management, team building, and growth strategies. Learn how to build sustainable and profitable businesses.',
                'lessons' => [
                    [
                        'title' => 'Financial Management for Small Business',
                        'description' => 'Managing cash flow and budgets.',
                        'duration_minutes' => 70,
                        'content' => 'Learn financial basics and budgeting for entrepreneurs.',
                    ],
                ]
            ],
            [
                'title' => 'Digital Marketing for Entrepreneurs',
                'category' => 'Entrepreneurship',
                'level' => 'Intermediate',
                'duration_hours' => 38,
                'instructor_name' => 'Nicole Lee',
                'instructor_title' => 'Digital Marketing Expert',
                'rating' => 4.8,
                'students_count' => 7200,
                'short_description' => 'Market your business effectively using digital channels.',
                'description' => 'Learn digital marketing strategies including social media, content marketing, SEO, and paid advertising to grow your business online.',
                'lessons' => [
                    [
                        'title' => 'Social Media Marketing Strategy',
                        'description' => 'Building your social media presence.',
                        'duration_minutes' => 60,
                        'content' => 'Learn social media platform strategies and best practices.',
                    ],
                ]
            ],

            // GENDER AND DEVELOPMENT (GAD)
            [
                'title' => 'Gender Equality and Inclusion',
                'category' => 'Gender and Development (GAD)',
                'level' => 'Beginner',
                'duration_hours' => 30,
                'instructor_name' => 'Dr. Angela Martinez',
                'instructor_title' => 'Gender Development Expert',
                'rating' => 4.7,
                'students_count' => 4200,
                'short_description' => 'Understand gender equality concepts and promote inclusive workplaces.',
                'description' => 'Learn about gender equality, diversity and inclusion, and how to create supportive environments. Understand the impact of gender equality on social and economic development.',
                'lessons' => [
                    [
                        'title' => 'Gender Concepts and Definitions',
                        'description' => 'Understanding gender vs sex and related concepts.',
                        'duration_minutes' => 50,
                        'content' => 'Learn foundational gender equality concepts.',
                    ],
                    [
                        'title' => 'Creating Inclusive Organizations',
                        'description' => 'Building diverse and inclusive workplaces.',
                        'duration_minutes' => 55,
                        'content' => 'Strategies for promoting inclusivity in organizations.',
                    ],
                ]
            ],
            [
                'title' => 'Women Empowerment and Leadership',
                'category' => 'Gender and Development (GAD)',
                'level' => 'Intermediate',
                'duration_hours' => 35,
                'instructor_name' => 'Sandra Thompson',
                'instructor_title' => 'Leadership Coach',
                'rating' => 4.8,
                'students_count' => 3800,
                'short_description' => 'Develop leadership skills and promote women empowerment.',
                'description' => 'Master leadership development and empowerment strategies. Learn how to overcome barriers and build confidence to lead organizations effectively.',
                'lessons' => [
                    [
                        'title' => 'Developing Leadership Skills',
                        'description' => 'Building effective leadership abilities.',
                        'duration_minutes' => 65,
                        'content' => 'Learn essential leadership competencies and skills.',
                    ],
                ]
            ],

            // HALAL AWARENESS PROGRAM
            [
                'title' => 'Halal Principles and Compliance',
                'category' => 'Halal Awareness Program',
                'level' => 'Beginner',
                'duration_hours' => 28,
                'instructor_name' => 'Imam Hassan',
                'instructor_title' => 'Halal Certification Specialist',
                'rating' => 4.6,
                'students_count' => 2500,
                'short_description' => 'Learn halal principles and compliance requirements for businesses.',
                'description' => 'Understand halal concepts, principles, and certification requirements. Learn how to ensure halal compliance in production, handling, and business operations.',
                'lessons' => [
                    [
                        'title' => 'Halal Concepts and Requirements',
                        'description' => 'Understanding halal principles.',
                        'duration_minutes' => 55,
                        'content' => 'Learn the fundamentals of halal in Islamic practice.',
                    ],
                    [
                        'title' => 'Halal Certification Process',
                        'description' => 'Steps to obtain halal certification.',
                        'duration_minutes' => 60,
                        'content' => 'Understand certification requirements and processes.',
                    ],
                ]
            ],
            [
                'title' => 'Halal Food Production and Handling',
                'category' => 'Halal Awareness Program',
                'level' => 'Intermediate',
                'duration_hours' => 32,
                'instructor_name' => 'Chef Fatima Khan',
                'instructor_title' => 'Halal Food Expert',
                'rating' => 4.7,
                'students_count' => 2800,
                'short_description' => 'Master halal food production standards and best practices.',
                'description' => 'Learn halal food production standards, ingredient sourcing, processing methods, and handling procedures to ensure halal compliance throughout the supply chain.',
                'lessons' => [
                    [
                        'title' => 'Halal Ingredient Sourcing',
                        'description' => 'Identifying and selecting halal ingredients.',
                        'duration_minutes' => 60,
                        'content' => 'Learn about halal-compliant ingredient selection.',
                    ],
                ]
            ],

            // HEATING, VENTILATING, AIRCONDITIONING AND REFRIGERATION TECHNOLOGY
            [
                'title' => 'HVAC System Installation and Maintenance',
                'category' => 'Heating, Ventilating, Airconditioning and Refrigeration Technology',
                'level' => 'Intermediate',
                'duration_hours' => 37,
                'instructor_name' => 'Robert Chen',
                'instructor_title' => 'HVAC Technician',
                'image_url' => 'images/courses/hvac-system.jpg',
                'rating' => 4.6,
                'students_count' => 3100,
                'short_description' => 'Learn HVAC system installation, maintenance, and troubleshooting.',
                'description' => 'Master heating and cooling systems, refrigeration cycles, and air quality control. Learn installation techniques, preventive maintenance, and diagnostic procedures for commercial and residential HVAC systems.',
                'lessons' => [
                    [
                        'title' => 'HVAC Fundamentals',
                        'description' => 'Understanding heating, cooling, and ventilation systems.',
                        'duration_minutes' => 75,
                        'content' => 'Learn HVAC system components and how they work together.',
                    ],
                    [
                        'title' => 'Refrigeration Cycles and Systems',
                        'description' => 'Understanding refrigeration principles.',
                        'duration_minutes' => 70,
                        'content' => 'Master refrigeration cycles and system operation.',
                    ],
                ]
            ],
            [
                'title' => 'Air Quality and Environmental Control',
                'category' => 'Heating, Ventilating, Airconditioning and Refrigeration Technology',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Dr. Michael O\'Brien',
                'instructor_title' => 'Environmental Engineer',
                'rating' => 4.7,
                'students_count' => 2600,
                'short_description' => 'Learn indoor air quality management and environmental control systems.',
                'description' => 'Master air quality monitoring, filtration systems, humidity control, and environmental standards. Learn to design and maintain healthy indoor environments.',
                'lessons' => [
                    [
                        'title' => 'Indoor Air Quality Standards',
                        'description' => 'Understanding IAQ guidelines and regulations.',
                        'duration_minutes' => 65,
                        'content' => 'Learn about indoor air quality standards and testing.',
                    ],
                ]
            ],

            // HUMAN HEALTH / HEALTH CARE
            [
                'title' => 'Basic Healthcare and First Aid',
                'category' => 'Human Health/ Health Care',
                'level' => 'Beginner',
                'duration_hours' => 32,
                'instructor_name' => 'Dr. Lisa Thompson',
                'instructor_title' => 'Certified Health Professional',
                'rating' => 4.8,
                'students_count' => 8900,
                'short_description' => 'Learn essential first aid and basic healthcare skills.',
                'description' => 'Master first aid techniques, CPR, emergency response, and basic healthcare knowledge. Learn to recognize medical emergencies and provide appropriate care.',
                'lessons' => [
                    [
                        'title' => 'CPR and Emergency Response',
                        'description' => 'Cardiopulmonary resuscitation techniques.',
                        'duration_minutes' => 60,
                        'content' => 'Learn hands-on CPR techniques and emergency assessment.',
                    ],
                    [
                        'title' => 'Wound Care and First Aid',
                        'description' => 'Treating wounds and injuries.',
                        'duration_minutes' => 55,
                        'content' => 'Learn first aid techniques for common injuries.',
                    ],
                ]
            ],
            [
                'title' => 'Healthcare Administration and Management',
                'category' => 'Human Health/ Health Care',
                'level' => 'Intermediate',
                'duration_hours' => 45,
                'instructor_name' => 'James Wilson',
                'instructor_title' => 'Healthcare Manager',
                'rating' => 4.6,
                'students_count' => 3500,
                'short_description' => 'Learn healthcare facility management and operations.',
                'description' => 'Master healthcare administration including patient management, facility operations, budgeting, and quality assurance. Understand healthcare regulations and best practices.',
                'lessons' => [
                    [
                        'title' => 'Patient Management Systems',
                        'description' => 'Healthcare information management.',
                        'duration_minutes' => 70,
                        'content' => 'Learn electronic health records and patient administration.',
                    ],
                ]
            ],
            [
                'title' => 'Nursing and Patient Care',
                'category' => 'Human Health/ Health Care',
                'level' => 'Advanced',
                'duration_hours' => 60,
                'instructor_name' => 'Nurse Sarah Anderson',
                'instructor_title' => 'Clinical Nurse Educator',
                'rating' => 4.8,
                'students_count' => 5200,
                'short_description' => 'Develop advanced nursing and patient care skills.',
                'description' => 'Master clinical nursing techniques, patient assessment, care planning, and therapeutic communication. Learn evidence-based nursing practices and patient safety.',
                'lessons' => [
                    [
                        'title' => 'Patient Assessment and Vital Signs',
                        'description' => 'Clinical assessment techniques.',
                        'duration_minutes' => 80,
                        'content' => 'Learn systematic patient assessment and monitoring.',
                    ],
                ]
            ],

            // LIFELONG LEARNING SKILLS
            [
                'title' => 'Effective Learning and Study Techniques',
                'category' => 'Lifelong Learning Skills',
                'level' => 'Beginner',
                'duration_hours' => 24,
                'instructor_name' => 'Dr. Patricia Moore',
                'instructor_title' => 'Learning Specialist',
                'rating' => 4.7,
                'students_count' => 6700,
                'short_description' => 'Learn effective study methods and improve your learning capabilities.',
                'description' => 'Master learning techniques including active recall, spaced repetition, note-taking, memory techniques, and exam preparation strategies. Optimize your learning efficiency.',
                'lessons' => [
                    [
                        'title' => 'Active Learning Strategies',
                        'description' => 'Techniques for active engagement with material.',
                        'duration_minutes' => 50,
                        'content' => 'Learn active learning methods and their effectiveness.',
                    ],
                    [
                        'title' => 'Time Management and Planning',
                        'description' => 'Managing study time effectively.',
                        'duration_minutes' => 45,
                        'content' => 'Strategies for organizing learning and study schedules.',
                    ],
                ]
            ],
            [
                'title' => 'Personal Development and Self-Improvement',
                'category' => 'Lifelong Learning Skills',
                'level' => 'Beginner',
                'duration_hours' => 30,
                'instructor_name' => 'Coach Michael Gray',
                'instructor_title' => 'Personal Development Coach',
                'rating' => 4.8,
                'students_count' => 7500,
                'short_description' => 'Invest in yourself with personal development and growth strategies.',
                'description' => 'Learn goal-setting, habit formation, self-reflection, and personal growth strategies. Develop mindset changes that support lifelong learning and personal success.',
                'lessons' => [
                    [
                        'title' => 'Goal Setting and Achievement',
                        'description' => 'Setting meaningful and achievable goals.',
                        'duration_minutes' => 60,
                        'content' => 'Learn SMART goal-setting frameworks and strategies.',
                    ],
                ]
            ],
            [
                'title' => 'Professional Development and Career Advancement',
                'category' => 'Lifelong Learning Skills',
                'level' => 'Intermediate',
                'duration_hours' => 35,
                'instructor_name' => 'Rebecca Lee',
                'instructor_title' => 'Career Coach',
                'rating' => 4.7,
                'students_count' => 5800,
                'short_description' => 'Accelerate your career growth with professional development strategies.',
                'description' => 'Master networking, skill development, resume building, interview techniques, and career planning. Learn how to advance in your chosen field and maximize career opportunities.',
                'lessons' => [
                    [
                        'title' => 'Career Planning Strategy',
                        'description' => 'Developing a long-term career plan.',
                        'duration_minutes' => 65,
                        'content' => 'Learn career development planning and strategizing.',
                    ],
                ]
            ],

            // MARITIME
            [
                'title' => 'Maritime Navigation and Safety',
                'category' => 'Maritime',
                'level' => 'Intermediate',
                'duration_hours' => 48,
                'instructor_name' => 'Captain Thomas Anderson',
                'instructor_title' => 'Experienced Sea Captain',
                'rating' => 4.7,
                'students_count' => 2200,
                'short_description' => 'Learn navigation, safety procedures, and maritime regulations.',
                'description' => 'Master maritime navigation using charts, GPS, and celestial navigation. Learn international maritime laws, safety procedures, and best practices for sailing and commercial shipping.',
                'lessons' => [
                    [
                        'title' => 'Chart Navigation and GPS',
                        'description' => 'Modern and traditional navigation methods.',
                        'duration_minutes' => 75,
                        'content' => 'Learn electronic and paper-based navigation techniques.',
                    ],
                    [
                        'title' => 'Maritime Safety and Emergency Procedures',
                        'description' => 'Safety protocols at sea.',
                        'duration_minutes' => 70,
                        'content' => 'Learn maritime safety regulations and emergency procedures.',
                    ],
                ]
            ],
            [
                'title' => 'Ship Operations and Management',
                'category' => 'Maritime',
                'level' => 'Advanced',
                'duration_hours' => 52,
                'instructor_name' => 'Commander James Clarke',
                'instructor_title' => 'Maritime Operations Expert',
                'rating' => 4.6,
                'students_count' => 1900,
                'short_description' => 'Learn ship management, cargo handling, and vessel operations.',
                'description' => 'Master ship operations including crew management, maintenance schedules, cargo handling, and compliance with international maritime standards. Learn vessel management best practices.',
                'lessons' => [
                    [
                        'title' => 'Crew Management and Leadership',
                        'description' => 'Managing maritime crews effectively.',
                        'duration_minutes' => 70,
                        'content' => 'Learn leadership in maritime environments.',
                    ],
                ]
            ],

            // PROCESS FOOD AND BEVERAGES
            [
                'title' => 'Food Processing and Preservation',
                'category' => 'Process Food and Beverages',
                'level' => 'Intermediate',
                'duration_hours' => 45,
                'instructor_name' => 'Dr. Susan Park',
                'instructor_title' => 'Food Science Specialist',
                'rating' => 4.7,
                'students_count' => 3300,
                'short_description' => 'Learn food processing techniques and preservation methods.',
                'description' => 'Master food processing, preservation techniques, food safety standards, and quality control. Learn about canning, freezing, fermentation, and modern food processing technology.',
                'lessons' => [
                    [
                        'title' => 'Food Preservation Methods',
                        'description' => 'Traditional and modern preservation techniques.',
                        'duration_minutes' => 70,
                        'content' => 'Learn various food preservation methods and their applications.',
                    ],
                    [
                        'title' => 'Food Safety and Quality Control',
                        'description' => 'Ensuring food safety standards.',
                        'duration_minutes' => 65,
                        'content' => 'Master food safety regulations and quality assurance.',
                    ],
                ]
            ],
            [
                'title' => 'Beverage Production and Brewing',
                'category' => 'Process Food and Beverages',
                'level' => 'Intermediate',
                'duration_hours' => 42,
                'instructor_name' => 'Marcus Robinson',
                'instructor_title' => 'Beverage Production Manager',
                'rating' => 4.6,
                'students_count' => 2500,
                'short_description' => 'Learn beverage production, brewing, and fermentation processes.',
                'description' => 'Master beverage production including coffee roasting, tea processing, juice production, and fermented beverages. Learn quality control and production efficiency.',
                'lessons' => [
                    [
                        'title' => 'Beverage Production Basics',
                        'description' => 'Introduction to beverage manufacturing.',
                        'duration_minutes' => 70,
                        'content' => 'Learn basic beverage production processes.',
                    ],
                ]
            ],
            [
                'title' => 'Commercial Kitchen and Food Service Management',
                'category' => 'Process Food and Beverages',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Chef Antonio Rodriguez',
                'instructor_title' => 'Executive Chef',
                'rating' => 4.8,
                'students_count' => 4200,
                'short_description' => 'Learn kitchen management, food preparation, and food service operations.',
                'description' => 'Master commercial kitchen operations, food preparation, nutrition, menu planning, and food service management. Learn hygiene standards and efficient kitchen operations.',
                'lessons' => [
                    [
                        'title' => 'Kitchen Organization and Food Safety',
                        'description' => 'Efficient and safe kitchen operations.',
                        'duration_minutes' => 65,
                        'content' => 'Learn kitchen management and food safety practices.',
                    ],
                ]
            ],

            // SOCIAL, COMMUNITY DEVELOPMENT AND OTHERS
            [
                'title' => 'Community Development and Social Programs',
                'category' => 'Social, Community Development and Others',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Dr. Victoria Santos',
                'instructor_title' => 'Community Development Expert',
                'rating' => 4.7,
                'students_count' => 3600,
                'short_description' => 'Learn community development principles and social program management.',
                'description' => 'Master community development strategies, social program planning, stakeholder engagement, and impact assessment. Learn how to create positive social change.',
                'lessons' => [
                    [
                        'title' => 'Community Needs Assessment',
                        'description' => 'Identifying community needs and assets.',
                        'duration_minutes' => 60,
                        'content' => 'Learn methods for assessing community needs.',
                    ],
                    [
                        'title' => 'Program Planning and Implementation',
                        'description' => 'Designing and implementing social programs.',
                        'duration_minutes' => 70,
                        'content' => 'Master program planning and management.',
                    ],
                ]
            ],
            [
                'title' => 'Social Entrepreneurship and Social Impact',
                'category' => 'Social, Community Development and Others',
                'level' => 'Intermediate',
                'duration_hours' => 38,
                'instructor_name' => 'Dr. Raymond Wu',
                'instructor_title' => 'Social Innovation Expert',
                'rating' => 4.8,
                'students_count' => 3200,
                'short_description' => 'Build social ventures that create positive social and environmental impact.',
                'description' => 'Learn about social entrepreneurship, impact measurement, sustainable business models, and funding for social enterprises. Create ventures that address social problems.',
                'lessons' => [
                    [
                        'title' => 'Impact Measurement and Evaluation',
                        'description' => 'Measuring social and environmental impact.',
                        'duration_minutes' => 65,
                        'content' => 'Learn frameworks for measuring social impact.',
                    ],
                ]
            ],
            [
                'title' => 'Nonprofit Management and Governance',
                'category' => 'Social, Community Development and Others',
                'level' => 'Intermediate',
                'duration_hours' => 42,
                'instructor_name' => 'Katherine Johnson',
                'instructor_title' => 'Nonprofit Director',
                'rating' => 4.6,
                'students_count' => 2800,
                'short_description' => 'Learn nonprofit operations, governance, and fundraising.',
                'description' => 'Master nonprofit management including board governance, fundraising, volunteer management, and financial stewardship. Learn sustainable nonprofit practices.',
                'lessons' => [
                    [
                        'title' => 'Nonprofit Fundraising Strategies',
                        'description' => 'Sustainable funding for nonprofits.',
                        'duration_minutes' => 75,
                        'content' => 'Learn fundraising strategies and grant writing.',
                    ],
                ]
            ],

            // TOURISM
            [
                'title' => 'Tourism Management and Hospitality',
                'category' => 'Tourism',
                'level' => 'Intermediate',
                'duration_hours' => 40,
                'instructor_name' => 'Maria Garcia',
                'instructor_title' => 'Hospitality Manager',
                'rating' => 4.7,
                'students_count' => 3900,
                'short_description' => 'Learn tourism industry management and hospitality service excellence.',
                'description' => 'Master tourism operations, customer service, hospitality management, and guest experience optimization. Learn to manage hotels, resorts, and tourism facilities professionally.',
                'lessons' => [
                    [
                        'title' => 'Guest Services Excellence',
                        'description' => 'Delivering exceptional customer service.',
                        'duration_minutes' => 60,
                        'content' => 'Learn hospitality service standards and guest satisfaction.',
                    ],
                    [
                        'title' => 'Tourism Product Development',
                        'description' => 'Creating tourism experiences and packages.',
                        'duration_minutes' => 65,
                        'content' => 'Learn to develop tourism products and experiences.',
                    ],
                ]
            ],
            [
                'title' => 'Travel and Tour Operations Management',
                'category' => 'Tourism',
                'level' => 'Intermediate',
                'duration_hours' => 38,
                'instructor_name' => 'David Morrison',
                'instructor_title' => 'Tour Operations Manager',
                'rating' => 4.6,
                'students_count' => 2400,
                'short_description' => 'Learn tour planning, logistics, and travel operations management.',
                'description' => 'Master tour planning, itinerary development, logistics coordination, and tour guide management. Learn to organize seamless travel experiences.',
                'lessons' => [
                    [
                        'title' => 'Tour Planning and Logistics',
                        'description' => 'Coordinating travel and tour operations.',
                        'duration_minutes' => 70,
                        'content' => 'Learn tour planning and logistics management.',
                    ],
                ]
            ],
            [
                'title' => 'Destination Management and Marketing',
                'category' => 'Tourism',
                'level' => 'Advanced',
                'duration_hours' => 45,
                'instructor_name' => 'Dr. Sandra Lee',
                'instructor_title' => 'Destination Marketing Expert',
                'rating' => 4.8,
                'students_count' => 2700,
                'short_description' => 'Learn destination marketing and sustainable tourism development.',
                'description' => 'Master destination branding, tourism marketing, sustainable development, and community-based tourism. Learn to develop and promote tourism destinations strategically.',
                'lessons' => [
                    [
                        'title' => 'Destination Branding Strategy',
                        'description' => 'Building strong destination brands.',
                        'duration_minutes' => 75,
                        'content' => 'Learn destination marketing and branding strategies.',
                    ],
                ]
            ],

            // TVET
            [
                'title' => 'Technical Skills Development and Certification',
                'category' => 'TVET',
                'level' => 'Intermediate',
                'duration_hours' => 50,
                'instructor_name' => 'Instructor Pedro Santos',
                'instructor_title' => 'TVET Program Director',
                'rating' => 4.7,
                'students_count' => 4800,
                'short_description' => 'Gain practical technical skills through industry-focused TVET programs.',
                'description' => 'Master hands-on technical skills in various trades. Learn industry-standard practices, safety protocols, and job-ready competencies. Prepare for vocational certification.',
                'lessons' => [
                    [
                        'title' => 'Tool Safety and Equipment Handling',
                        'description' => 'Safe use of tools and equipment.',
                        'duration_minutes' => 55,
                        'content' => 'Learn tool safety and proper equipment handling.',
                    ],
                    [
                        'title' => 'Technical Skill Practice and Assessment',
                        'description' => 'Hands-on skill development.',
                        'duration_minutes' => 90,
                        'content' => 'Practice technical skills under professional guidance.',
                    ],
                ]
            ],
            [
                'title' => 'Vocational Entrepreneurship and Self-Employment',
                'category' => 'TVET',
                'level' => 'Intermediate',
                'duration_hours' => 35,
                'instructor_name' => 'Luis Garcia',
                'instructor_title' => 'Vocational Business Mentor',
                'rating' => 4.6,
                'students_count' => 3100,
                'short_description' => 'Start your own business using TVET skills and practical knowledge.',
                'description' => 'Learn to establish and manage a technical or vocational business. Combine technical expertise with business management to create successful ventures.',
                'lessons' => [
                    [
                        'title' => 'Setting Up Your Technical Business',
                        'description' => 'Starting a vocational business.',
                        'duration_minutes' => 65,
                        'content' => 'Learn business setup and initial startup planning.',
                    ],
                ]
            ],
            [
                'title' => 'Workplace Safety and Occupational Health',
                'category' => 'TVET',
                'level' => 'Beginner',
                'duration_hours' => 25,
                'instructor_name' => 'Rebecca Cohen',
                'instructor_title' => 'Occupational Health and Safety Officer',
                'rating' => 4.8,
                'students_count' => 6200,
                'short_description' => 'Master workplace safety standards and occupational health practices.',
                'description' => 'Learn workplace hazard identification, safety protocols, emergency procedures, and occupational health standards. Essential for all technical workers.',
                'lessons' => [
                    [
                        'title' => 'Hazard Identification and Risk Assessment',
                        'description' => 'Identifying and assessing workplace hazards.',
                        'duration_minutes' => 50,
                        'content' => 'Learn to identify and assess workplace risks.',
                    ],
                ]
            ],

            // TOP COURSES WITH ACCESSIBILITY FEATURES
            [
                'title' => 'Accessible Web Design for Everyone',
                'category' => 'TOP Courses with Accessibility Features',
                'level' => 'Intermediate',
                'duration_hours' => 35,
                'instructor_name' => 'Emma Williams',
                'instructor_title' => 'Accessibility Specialist',
                'rating' => 4.9,
                'students_count' => 5600,
                'short_description' => 'Learn to design inclusive, accessible websites for all users.',
                'description' => 'Master web accessibility standards (WCAG), inclusive design principles, and accessible technology. Learn to create digital experiences that work for everyone, including people with disabilities.',
                'lessons' => [
                    [
                        'title' => 'Web Accessibility Standards and WCAG',
                        'description' => 'Understanding accessibility guidelines.',
                        'duration_minutes' => 65,
                        'content' => 'Learn Web Content Accessibility Guidelines.',
                    ],
                    [
                        'title' => 'Accessible Design Implementation',
                        'description' => 'Practical accessibility techniques.',
                        'duration_minutes' => 70,
                        'content' => 'Learn practical ways to implement accessibility.',
                    ],
                ]
            ],
            [
                'title' => 'Inclusive Teaching and Universal Learning Design',
                'category' => 'TOP Courses with Accessibility Features',
                'level' => 'Intermediate',
                'duration_hours' => 32,
                'instructor_name' => 'Dr. Christopher Thomas',
                'instructor_title' => 'Educational Accessibility Expert',
                'rating' => 4.8,
                'students_count' => 4300,
                'short_description' => 'Learn to teach and create learning materials accessible to all students.',
                'description' => 'Master universal design for learning (UDL), inclusive teaching strategies, and accessible educational technology. Learn to support diverse learners effectively.',
                'lessons' => [
                    [
                        'title' => 'Universal Design for Learning (UDL)',
                        'description' => 'Creating inclusive learning environments.',
                        'duration_minutes' => 60,
                        'content' => 'Learn UDL principles and implementation.',
                    ],
                ]
            ],
            [
                'title' => 'Assistive Technology and Digital Inclusion',
                'category' => 'TOP Courses with Accessibility Features',
                'level' => 'Intermediate',
                'duration_hours' => 38,
                'instructor_name' => 'Michael Park',
                'instructor_title' => 'Assistive Technology Expert',
                'rating' => 4.7,
                'students_count' => 3700,
                'short_description' => 'Learn about assistive technologies that enable digital participation.',
                'description' => 'Explore assistive technology tools, adaptive devices, and digital inclusion strategies. Learn how to support people with disabilities in using technology effectively.',
                'lessons' => [
                    [
                        'title' => 'Assistive Technology Fundamentals',
                        'description' => 'Overview of assistive technologies.',
                        'duration_minutes' => 70,
                        'content' => 'Learn about different assistive technologies and their uses.',
                    ],
                ]
            ],

            // Modern Web Development (original courses kept)
            [
                'title' => 'Modern Web Development with HTML, CSS & JavaScript',
                'category' => 'Information and Communication Technology',
                'level' => 'Beginner',
                'duration_hours' => 40,
                'instructor_name' => 'Sarah Johnson',
                'instructor_title' => 'Senior Web Developer',
                'rating' => 4.8,
                'students_count' => 12500,
                'short_description' => 'Learn to build responsive websites from scratch using modern HTML5, CSS3, and JavaScript. Perfect for beginners.',
                'description' => 'This comprehensive course will teach you everything you need to know to become a web developer. Starting from the fundamentals of HTML5 and CSS3, you\'ll progress to mastering JavaScript, responsive design principles, and modern web development workflows.

By the end of this course, you\'ll have built multiple real-world projects including a portfolio website, e-commerce product page, and interactive web application. You\'ll understand web standards, accessibility best practices, and how to leverage popular frameworks and tools used by professional developers.

This course is perfect for anyone looking to start a career in web development or enhance their existing skills. No prior programming experience needed!',
                'lessons' => [
                    [
                        'title' => 'Introduction to Web Development',
                        'description' => 'Understand the fundamentals of how the web works and set up your development environment.',
                        'duration_minutes' => 45,
                        'content' => 'In this lesson, we\'ll explore the basics of HTML structure and semantic markup.',
                    ],
                    [
                        'title' => 'HTML5 Fundamentals',
                        'description' => 'Master HTML5 elements, semantic markup, and proper document structure.',
                        'duration_minutes' => 60,
                        'content' => 'Learn about HTML5 elements including headers, navigation, articles, and more.',
                    ],
                    [
                        'title' => 'CSS3 Styling & Layout',
                        'description' => 'Style web pages with CSS3, including flexbox and grid layouts.',
                        'duration_minutes' => 75,
                        'content' => 'Discover modern CSS techniques for creating beautiful, responsive layouts.',
                    ],
                    [
                        'title' => 'Responsive Design',
                        'description' => 'Create websites that work perfectly on all devices using media queries.',
                        'duration_minutes' => 60,
                        'content' => 'Learn mobile-first design principles and responsive web design patterns.',
                    ],
                    [
                        'title' => 'JavaScript Basics',
                        'description' => 'Introduction to JavaScript programming language and DOM manipulation.',
                        'duration_minutes' => 90,
                        'content' => 'Understand variables, data types, functions, and how to manipulate the DOM.',
                    ],
                ]
            ],
            [
                'title' => 'React.js - Build Modern Web Apps',
                'category' => 'Information and Communication Technology',
                'level' => 'Intermediate',
                'duration_hours' => 50,
                'instructor_name' => 'Mike Chen',
                'instructor_title' => 'React Expert & Tech Lead',
                'rating' => 4.9,
                'students_count' => 8900,
                'short_description' => 'Become a React expert. Build interactive UIs with components, hooks, and state management.',
                'description' => 'Take your JavaScript skills to the next level with React.js, the most popular JavaScript library for building user interfaces. This course covers everything from basic concepts to advanced patterns used in production applications.

You\'ll learn about components, JSX, props, state, hooks, and context API. We\'ll build real-world projects including a task management application, weather dashboard, and e-commerce platform. You\'ll also learn best practices for code organization, testing, and performance optimization.

By completing this course, you\'ll be ready to work on professional React projects and understand how modern web applications are built.',
                'lessons' => [
                    [
                        'title' => 'React Fundamentals',
                        'description' => 'Understand React components, JSX, and the virtual DOM.',
                        'duration_minutes' => 75,
                        'content' => 'Learn how React works and how to build your first components.',
                    ],
                    [
                        'title' => 'Components & Props',
                        'description' => 'Master functional components and prop passing.',
                        'duration_minutes' => 60,
                        'content' => 'Create reusable components with props for maximum flexibility.',
                    ],
                    [
                        'title' => 'State & Hooks',
                        'description' => 'Learn useState, useEffect, and custom hooks.',
                        'duration_minutes' => 90,
                        'content' => 'Master React hooks for managing component state and side effects.',
                    ],
                    [
                        'title' => 'State Management with Context',
                        'description' => 'Manage global state with Context API.',
                        'duration_minutes' => 70,
                        'content' => 'Learn how to use Context API to avoid prop drilling.',
                    ],
                ]
            ],
            [
                'title' => 'Full-Stack Web Development with Laravel',
                'category' => 'Information and Communication Technology',
                'level' => 'Intermediate',
                'duration_hours' => 60,
                'instructor_name' => 'Alex Rodriguez',
                'instructor_title' => 'Full Stack Developer',
                'rating' => 4.7,
                'students_count' => 6500,
                'short_description' => 'Build complete web applications with Laravel. Learn backend development, databases, and deployment.',
                'description' => 'Master Laravel, the most elegant PHP framework for building modern web applications. This course takes you from beginner to building production-ready applications.

Learn about routing, controllers, models, migrations, and eloquent ORM. You\'ll understand how to build APIs, handle authentication, manage databases, and deploy applications to production. We\'ll build a complete project management application with user authentication and real-time features.

This course is perfect for developers wanting to build server-side applications and understand how to create scalable web backends.',
                'lessons' => [
                    [
                        'title' => 'Laravel Setup & Basics',
                        'description' => 'Install Laravel and understand the directory structure.',
                        'duration_minutes' => 50,
                        'content' => 'Set up your Laravel development environment.',
                    ],
                    [
                        'title' => 'Routing & Controllers',
                        'description' => 'Build routes and handle requests with controllers.',
                        'duration_minutes' => 65,
                        'content' => 'Learn Laravel routing and controller patterns.',
                    ],
                    [
                        'title' => 'Database & Models',
                        'description' => 'Work with databases using migrations and Eloquent ORM.',
                        'duration_minutes' => 85,
                        'content' => 'Master Eloquent and database migrations.',
                    ],
                ]
            ],
            [
                'title' => 'Data Science with Python',
                'category' => 'Information and Communication Technology',
                'level' => 'Intermediate',
                'duration_hours' => 55,
                'instructor_name' => 'Dr. Emily Watson',
                'instructor_title' => 'Data Science Lead',
                'rating' => 4.8,
                'students_count' => 11200,
                'short_description' => 'Learn data analysis, visualization, and machine learning with Python.',
                'description' => 'Become proficient in Python for data science. Learn how to analyze datasets, create visualizations, and build machine learning models.

This course covers NumPy, Pandas, Matplotlib, Seaborn, and Scikit-learn. You\'ll work with real-world datasets, perform exploratory data analysis, and build predictive models. We\'ll work on projects including housing price prediction, customer segmentation, and sentiment analysis.

Perfect for anyone wanting to start a career in data science or enhance their analytical skills.',
                'lessons' => [
                    [
                        'title' => 'Python Basics for Data',
                        'description' => 'Python fundamentals and data structures.',
                        'duration_minutes' => 70,
                        'content' => 'Learn Python basics for data science.',
                    ],
                    [
                        'title' => 'NumPy & Pandas',
                        'description' => 'Work with numerical arrays and dataframes.',
                        'duration_minutes' => 90,
                        'content' => 'Master NumPy and Pandas for data manipulation.',
                    ],
                ]
            ],
        ];

        foreach ($courses as $courseData) {
            $lessons = $courseData['lessons'] ?? [];
            unset($courseData['lessons']);

            // ensure a slug exists and use updateOrCreate to avoid unique constraint failures
            $courseData['slug'] = Str::slug($courseData['title']);

            $course = Course::updateOrCreate(
                ['slug' => $courseData['slug']],
                $courseData
            );

            foreach ($lessons as $index => $lessonData) {
                $attributes = [
                    'course_id' => $course->id,
                    'title' => $lessonData['title'],
                ];

                $values = [
                    'description' => $lessonData['description'] ?? null,
                    'content' => $lessonData['content'] ?? null,
                    'duration_minutes' => $lessonData['duration_minutes'] ?? ($lessonData['duration'] ?? 0),
                    'order' => $index + 1,
                    'is_published' => $lessonData['is_published'] ?? true,
                ];

                Lesson::updateOrCreate($attributes, $values);
            }
        }
    }
}
