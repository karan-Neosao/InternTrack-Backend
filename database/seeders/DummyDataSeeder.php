<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\StudentProfile;
use App\Models\Internship;
use App\Models\Application;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Admin User Exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@interntrack.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now(),
            ]
        );
        $admin->update(['role' => 'admin', 'is_active' => true]);

        // 2. Categories
        $categoriesData = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Frontend, Backend, and Full-Stack web application development roles.',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'Cross-platform Flutter, Android (Kotlin), and iOS (Swift) mobile engineering.',
                'is_active' => true,
            ],
            [
                'name' => 'Data Science & AI',
                'slug' => 'data-science-ai',
                'description' => 'Machine Learning, Deep Learning, NLP, Data Analytics, and Big Data pipelines.',
                'is_active' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'User Interface, User Experience research, Figma design systems, and wireframing.',
                'is_active' => true,
            ],
            [
                'name' => 'Cloud & DevOps',
                'slug' => 'cloud-devops',
                'description' => 'AWS, Docker, Kubernetes, CI/CD pipeline automation, and Cloud infrastructure.',
                'is_active' => true,
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Network security, penetration testing, vulnerability assessment, and ethical hacking.',
                'is_active' => true,
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Growth marketing, search engine optimization (SEO), social media, and content writing.',
                'is_active' => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::firstOrCreate(
                ['slug' => $cData['slug']],
                $cData
            );
        }

        // 3. Companies & Company Profiles
        $companiesData = [
            [
                'user' => [
                    'name' => 'Google India',
                    'email' => 'careers@google.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(5),
                ],
                'profile' => [
                    'company_name' => 'Google India Pvt Ltd',
                    'website' => 'https://careers.google.com',
                    'industry' => 'Information Technology',
                    'location' => 'Bengaluru, Karnataka',
                    'description' => 'Global technology leader specializing in search engine, cloud services, software development, and AI innovation.',
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Microsoft India',
                    'email' => 'jobs@microsoft.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(5),
                ],
                'profile' => [
                    'company_name' => 'Microsoft India R&D',
                    'website' => 'https://careers.microsoft.com',
                    'industry' => 'Software & Cloud',
                    'location' => 'Hyderabad, Telangana',
                    'description' => 'Empowering every person and organization to achieve more with world-class operating systems, cloud, and productivity tools.',
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Razorpay Software',
                    'email' => 'talent@razorpay.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(4),
                ],
                'profile' => [
                    'company_name' => 'Razorpay Software Pvt Ltd',
                    'website' => 'https://razorpay.com',
                    'industry' => 'FinTech & Payments',
                    'location' => 'Bengaluru, Karnataka',
                    'description' => 'India’s premier payment gateway and neo-banking platform powering millions of businesses.',
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Tata Consultancy Services',
                    'email' => 'campus@tcs.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(4),
                ],
                'profile' => [
                    'company_name' => 'Tata Consultancy Services (TCS)',
                    'website' => 'https://www.tcs.com',
                    'industry' => 'IT Services & Consulting',
                    'location' => 'Pune / Mumbai, Maharashtra',
                    'description' => 'A global IT and business consulting powerhouse driving transformative digital solutions for global enterprises.',
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Zomato Ltd',
                    'email' => 'tech@zomato.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(3),
                ],
                'profile' => [
                    'company_name' => 'Zomato Tech',
                    'website' => 'https://www.zomato.com',
                    'industry' => 'Consumer Internet & Logistics',
                    'location' => 'Gurugram, Haryana',
                    'description' => 'Connecting millions of foodies with restaurants and quick-commerce delivery via high-performance apps.',
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'name' => 'Infosys Limited',
                    'email' => 'recruitment@infosys.com',
                    'password' => Hash::make('password123'),
                    'role' => 'company',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(2),
                ],
                'profile' => [
                    'company_name' => 'Infosys Limited',
                    'website' => 'https://www.infosys.com',
                    'industry' => 'Digital Enterprise Services',
                    'location' => 'Pune, Maharashtra',
                    'description' => 'Global leader in next-generation digital services and consulting helping clients navigate digital transformation.',
                    'is_verified' => true,
                ],
            ],
        ];

        $companies = [];
        foreach ($companiesData as $c) {
            $companyUser = User::firstOrCreate(
                ['email' => $c['user']['email']],
                $c['user']
            );
            $companyUser->update(['role' => 'company', 'is_active' => true]);

            CompanyProfile::updateOrCreate(
                ['user_id' => $companyUser->id],
                $c['profile']
            );

            $companies[$companyUser->name] = $companyUser;
        }

        // 4. Students & Student Profiles
        $studentsData = [
            [
                'user' => [
                    'name' => 'Aarav Sharma',
                    'email' => 'aarav.sharma@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(5),
                ],
                'profile' => [
                    'phone' => '+91 98220 11223',
                    'college' => 'College of Engineering, Pune (COEP)',
                    'course' => 'B.Tech Computer Science',
                    'graduation_year' => '2026',
                    'skills' => 'Flutter, Dart, Firebase, REST APIs, Git, State Management',
                    'linkedin_url' => 'https://linkedin.com/in/aarav-sharma-flutter',
                ],
            ],
            [
                'user' => [
                    'name' => 'Priya Patel',
                    'email' => 'priya.patel@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(4),
                ],
                'profile' => [
                    'phone' => '+91 98220 22334',
                    'college' => 'Vishwakarma Institute of Technology (VIT Pune)',
                    'course' => 'B.Tech Information Technology',
                    'graduation_year' => '2026',
                    'skills' => 'React, TypeScript, Node.js, Express, MongoDB, Tailwind CSS',
                    'linkedin_url' => 'https://linkedin.com/in/priya-patel-dev',
                ],
            ],
            [
                'user' => [
                    'name' => 'Rohan Deshmukh',
                    'email' => 'rohan.deshmukh@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(4),
                ],
                'profile' => [
                    'phone' => '+91 98220 33445',
                    'college' => 'Pune Institute of Computer Technology (PICT)',
                    'course' => 'B.E. Computer Engineering',
                    'graduation_year' => '2027',
                    'skills' => 'Python, Machine Learning, PyTorch, Pandas, SQL, NumPy',
                    'linkedin_url' => 'https://linkedin.com/in/rohan-deshmukh-ml',
                ],
            ],
            [
                'user' => [
                    'name' => 'Sneha Kulkarni',
                    'email' => 'sneha.kulkarni@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(3),
                ],
                'profile' => [
                    'phone' => '+91 98220 44556',
                    'college' => 'MIT World Peace University (MIT-WPU)',
                    'course' => 'B.Des User Experience Design',
                    'graduation_year' => '2026',
                    'skills' => 'Figma, Adobe XD, Wireframing, User Research, Design Systems',
                    'linkedin_url' => 'https://linkedin.com/in/sneha-kulkarni-ux',
                ],
            ],
            [
                'user' => [
                    'name' => 'Aditya Joshi',
                    'email' => 'aditya.joshi@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(2),
                ],
                'profile' => [
                    'phone' => '+91 98220 55667',
                    'college' => 'Savitribai Phule Pune University (SPPU)',
                    'course' => 'Master of Computer Applications (MCA)',
                    'graduation_year' => '2026',
                    'skills' => 'PHP, Laravel, MySQL, REST APIs, Docker, Linux, Git',
                    'linkedin_url' => 'https://linkedin.com/in/aditya-joshi-backend',
                ],
            ],
            [
                'user' => [
                    'name' => 'Ananya Verma',
                    'email' => 'ananya.verma@gmail.com',
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'is_active' => true,
                    'created_at' => Carbon::now()->subMonths(1),
                ],
                'profile' => [
                    'phone' => '+91 98220 66778',
                    'college' => 'Symbiosis Institute of Technology (SIT)',
                    'course' => 'B.Tech Computer Science',
                    'graduation_year' => '2027',
                    'skills' => 'AWS, Docker, Kubernetes, Linux, CI/CD, Git, Python',
                    'linkedin_url' => 'https://linkedin.com/in/ananya-verma-cloud',
                ],
            ],
        ];

        $students = [];
        foreach ($studentsData as $s) {
            $studentUser = User::firstOrCreate(
                ['email' => $s['user']['email']],
                $s['user']
            );
            $studentUser->update(['role' => 'student', 'is_active' => true]);

            StudentProfile::updateOrCreate(
                ['user_id' => $studentUser->id],
                $s['profile']
            );

            $students[$studentUser->name] = $studentUser;
        }

        // 5. Internships (Rich, realistic listings for students & mobile app)
        $internshipsData = [
            [
                'company' => 'Razorpay Software',
                'category' => 'mobile-app-development',
                'title' => 'Flutter Mobile App Developer Intern',
                'description' => 'Join our Core Merchant Experience team to build sleek, high-performing mobile apps using Flutter. You will build responsive UI components, handle complex client-side state management, integrate secure payment and auth APIs, and write modular unit tests. Great mentorship and real production impact!',
                'skills' => 'Flutter, Dart, REST APIs, Provider/Bloc, Git, Clean Architecture',
                'location' => 'Remote / Work From Home',
                'work_type' => 'remote',
                'stipend' => 25000.00,
                'duration' => '3 Months',
                'deadline' => Carbon::now()->addDays(30)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'company' => 'Google India',
                'category' => 'web-development',
                'title' => 'Full Stack Web Engineering Intern',
                'description' => 'Exciting opportunity to build scalable web applications used by millions of developers and enterprise users. You will write clean, well-documented code across React and Node.js microservices, design performant database queries, and participate in peer code reviews following world-class engineering standards.',
                'skills' => 'React.js, TypeScript, Node.js, PostgreSQL, Docker, Git',
                'location' => 'Bengaluru, Karnataka',
                'work_type' => 'hybrid',
                'stipend' => 45000.00,
                'duration' => '6 Months',
                'deadline' => Carbon::now()->addDays(45)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'company' => 'Microsoft India',
                'category' => 'data-science-ai',
                'title' => 'AI & Machine Learning Research Intern',
                'description' => 'Work closely with principal research scientists on large language models and intelligent conversational assistants. You will preprocess enterprise corpora, benchmark transformer architectures, fine-tune models, and optimize inference endpoints for low-latency production serving.',
                'skills' => 'Python, PyTorch, Transformers, NLP, HuggingFace, Scikit-Learn',
                'location' => 'Hyderabad, Telangana',
                'work_type' => 'hybrid',
                'stipend' => 50000.00,
                'duration' => '6 Months',
                'deadline' => Carbon::now()->addDays(60)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'company' => 'Zomato Ltd',
                'category' => 'ui-ux-design',
                'title' => 'UI/UX Product Design Intern',
                'description' => 'Help shape the future of dining, ordering, and delivery apps! You will conduct customer interviews, build high-fidelity interactive wireframes in Figma, test prototypes with real users, and craft pixel-perfect mobile micro-interactions that elevate customer happiness.',
                'skills' => 'Figma, User Research, Wireframing, Interaction Design, Mobile UI',
                'location' => 'Gurugram / Remote',
                'work_type' => 'remote',
                'stipend' => 20000.00,
                'duration' => '3 Months',
                'deadline' => Carbon::now()->addDays(20)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'company' => 'Razorpay Software',
                'category' => 'web-development',
                'title' => 'Backend Engineering Intern (PHP & Laravel)',
                'description' => 'Work on mission-critical financial backend services. You will architect RESTful API endpoints, implement asynchronous queue workers, optimize MySQL and Redis caching layers, and maintain rock-solid data integrity under high concurrent transaction volumes.',
                'skills' => 'PHP 8.2+, Laravel Framework, MySQL, Redis, REST API, Unit Testing',
                'location' => 'Remote',
                'work_type' => 'remote',
                'stipend' => 28000.00,
                'duration' => '4 Months',
                'deadline' => Carbon::now()->addDays(40)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(18),
            ],
            [
                'company' => 'Tata Consultancy Services',
                'category' => 'cloud-devops',
                'title' => 'Cloud & DevOps Automation Intern',
                'description' => 'Participate in automated infrastructure deployment and multi-cloud management. You will build CI/CD pipelines, containerize microservices using Docker, deploy test clusters on Kubernetes, and write Bash and Python automation scripts for enterprise reliability.',
                'skills' => 'Linux, AWS, Docker, Kubernetes, Jenkins CI/CD, Git, Bash',
                'location' => 'Pune, Maharashtra',
                'work_type' => 'onsite',
                'stipend' => 20000.00,
                'duration' => '6 Months',
                'deadline' => Carbon::now()->addDays(50)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'company' => 'Zomato Ltd',
                'category' => 'web-development',
                'title' => 'Frontend React.js Developer Intern',
                'description' => 'Build blazing-fast, delightful web interfaces for Zomato restaurant partners. You will develop accessible, responsive components using React, Tailwind CSS, and Next.js, optimizing web performance metrics (Core Web Vitals) across desktop and mobile browsers.',
                'skills' => 'React, Next.js, JavaScript (ES6+), Tailwind CSS, Redux Toolkit',
                'location' => 'Gurugram, Haryana',
                'work_type' => 'hybrid',
                'stipend' => 22000.00,
                'duration' => '3 Months',
                'deadline' => Carbon::now()->addDays(35)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'company' => 'Infosys Limited',
                'category' => 'data-science-ai',
                'title' => 'Business Data Analyst Intern',
                'description' => 'Transform raw operational data into actionable business intelligence. You will write complex SQL queries to aggregate key performance metrics, create interactive visual dashboards in Power BI and Tableau, and present weekly insights to leadership stakeholders.',
                'skills' => 'SQL, Advanced Excel, Power BI, Python Pandas, Data Storytelling',
                'location' => 'Pune, Maharashtra',
                'work_type' => 'onsite',
                'stipend' => 18000.00,
                'duration' => '3 Months',
                'deadline' => Carbon::now()->addDays(25)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(14),
            ],
            [
                'company' => 'Microsoft India',
                'category' => 'mobile-app-development',
                'title' => 'Android SDK Developer Intern (Kotlin)',
                'description' => 'Build native Android applications with state-of-the-art tools. You will implement modern UI with Jetpack Compose, asynchronous flows with Kotlin Coroutines, MVVM architecture, and offline data sync for enterprise business tools.',
                'skills' => 'Kotlin, Jetpack Compose, Android SDK, Coroutines, Room DB, MVVM',
                'location' => 'Hyderabad, Telangana',
                'work_type' => 'onsite',
                'stipend' => 42000.00,
                'duration' => '6 Months',
                'deadline' => Carbon::now()->addDays(55)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(22),
            ],
            [
                'company' => 'Tata Consultancy Services',
                'category' => 'cybersecurity',
                'title' => 'Cybersecurity & Ethical Hacking Trainee',
                'description' => 'Protect digital assets against sophisticated threats. You will conduct penetration tests against staging servers, scan for OWASP Top 10 vulnerabilities, review code for injection flaws, and document security incident remediation reports.',
                'skills' => 'Network Protocols, Kali Linux, OWASP Top 10, Burp Suite, Python Scripting',
                'location' => 'Mumbai, Maharashtra',
                'work_type' => 'hybrid',
                'stipend' => 22000.00,
                'duration' => '6 Months',
                'deadline' => Carbon::now()->addDays(45)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(28),
            ],
            [
                'company' => 'Zomato Ltd',
                'category' => 'digital-marketing',
                'title' => 'Growth & Social Media Marketing Intern',
                'description' => 'Help create viral social media campaigns, engage with the foodie community on Instagram and Twitter/X, track organic conversion funnels, and assist in creative copywriting for marketing notifications and newsletters.',
                'skills' => 'Content Strategy, Copywriting, Social Media Marketing, Canva, Analytics',
                'location' => 'Remote',
                'work_type' => 'remote',
                'stipend' => 15000.00,
                'duration' => '2 Months',
                'deadline' => Carbon::now()->addDays(15)->toDateString(),
                'status' => 'active',
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'company' => 'Infosys Limited',
                'category' => 'web-development',
                'title' => 'Legacy Modernization Java Intern (Archive)',
                'description' => 'Closed archive listing for enterprise system modernization with Java Spring Boot and Angular.',
                'skills' => 'Java, Spring Boot, MySQL, REST API',
                'location' => 'Pune, Maharashtra',
                'work_type' => 'onsite',
                'stipend' => 18000.00,
                'duration' => '3 Months',
                'deadline' => Carbon::now()->subDays(5)->toDateString(),
                'status' => 'closed',
                'created_at' => Carbon::now()->subMonths(2),
            ],
        ];

        $internships = [];
        foreach ($internshipsData as $iData) {
            $companyUser = $companies[$iData['company']] ?? null;
            $cat = $categories[$iData['category']] ?? null;

            if ($companyUser && $cat) {
                $internship = Internship::updateOrCreate(
                    [
                        'company_id' => $companyUser->id,
                        'title' => $iData['title'],
                    ],
                    [
                        'category_id' => $cat->id,
                        'description' => $iData['description'],
                        'skills' => $iData['skills'],
                        'location' => $iData['location'],
                        'work_type' => $iData['work_type'],
                        'stipend' => $iData['stipend'],
                        'duration' => $iData['duration'],
                        'deadline' => $iData['deadline'],
                        'status' => $iData['status'],
                        'created_at' => $iData['created_at'],
                        'updated_at' => Carbon::now(),
                    ]
                );
                $internships[$iData['title']] = $internship;
            }
        }

        // 6. Applications (Realistic student applications for dashboard & mobile)
        $applicationsData = [
            [
                'student' => 'Aarav Sharma',
                'internship' => 'Flutter Mobile App Developer Intern',
                'status' => 'reviewed',
                'cover_letter' => 'Hello Hiring Team, I have been building Flutter applications for the past 2 years. I have experience with Bloc state management, clean architecture, and payment gateways. I would love to contribute to Razorpay mobile experience!',
                'applied_at' => Carbon::now()->subDays(10),
            ],
            [
                'student' => 'Aarav Sharma',
                'internship' => 'Android SDK Developer Intern (Kotlin)',
                'status' => 'pending',
                'cover_letter' => 'Dear Microsoft team, As a mobile developer exploring Kotlin and Jetpack Compose, I am very keen on mastering enterprise Android architecture. Please find my portfolio on GitHub.',
                'applied_at' => Carbon::now()->subDays(4),
            ],
            [
                'student' => 'Priya Patel',
                'internship' => 'Full Stack Web Engineering Intern',
                'status' => 'accepted',
                'cover_letter' => 'Respected Google Recruiters, I have built and deployed multiple MERN stack web applications with responsive design and high performance. Working at Google would be an incredible milestone for my career.',
                'applied_at' => Carbon::now()->subDays(15),
            ],
            [
                'student' => 'Priya Patel',
                'internship' => 'Frontend React.js Developer Intern',
                'status' => 'reviewed',
                'cover_letter' => 'Hi Zomato Team! I love your consumer apps and web design. I have extensive experience with React, Tailwind CSS, and state management, and I am excited to help build partner dashboards.',
                'applied_at' => Carbon::now()->subDays(8),
            ],
            [
                'student' => 'Rohan Deshmukh',
                'internship' => 'AI & Machine Learning Research Intern',
                'status' => 'accepted',
                'cover_letter' => 'Dear Microsoft Research, My academic research focuses on NLP transformer architectures and document summarization. I have hands-on experience training PyTorch models on GPUs.',
                'applied_at' => Carbon::now()->subDays(18),
            ],
            [
                'student' => 'Rohan Deshmukh',
                'internship' => 'Business Data Analyst Intern',
                'status' => 'reviewed',
                'cover_letter' => 'Hello Infosys Team, I have strong analytical skills with SQL, Python Pandas, and Power BI. I have completed several dataset analyses on Kaggle and look forward to contributing.',
                'applied_at' => Carbon::now()->subDays(9),
            ],
            [
                'student' => 'Sneha Kulkarni',
                'internship' => 'UI/UX Product Design Intern',
                'status' => 'accepted',
                'cover_letter' => 'Hi Zomato Design Team! I am a passionate UX design student with a portfolio of 4 comprehensive case studies. I specialize in user journey mapping and crafting design systems in Figma.',
                'applied_at' => Carbon::now()->subDays(7),
            ],
            [
                'student' => 'Aditya Joshi',
                'internship' => 'Backend Engineering Intern (PHP & Laravel)',
                'status' => 'pending',
                'cover_letter' => 'Greetings Razorpay team! I have built several projects using Laravel 11/12 and MySQL. I enjoy solving database query optimization challenges and building reliable REST APIs.',
                'applied_at' => Carbon::now()->subDays(5),
            ],
            [
                'student' => 'Aditya Joshi',
                'internship' => 'Cloud & DevOps Automation Intern',
                'status' => 'rejected',
                'cover_letter' => 'Looking to expand my backend skills into DevOps and cloud automation.',
                'applied_at' => Carbon::now()->subDays(20),
            ],
            [
                'student' => 'Ananya Verma',
                'internship' => 'Cloud & DevOps Automation Intern',
                'status' => 'reviewed',
                'cover_letter' => 'Respected TCS Hiring Team, I hold an AWS Certified Cloud Practitioner credential and have built automated Docker deployment workflows on GitHub Actions.',
                'applied_at' => Carbon::now()->subDays(12),
            ],
            [
                'student' => 'Ananya Verma',
                'internship' => 'Cybersecurity & Ethical Hacking Trainee',
                'status' => 'pending',
                'cover_letter' => 'I have a strong interest in ethical hacking, networking protocols, and securing cloud infrastructure. Eager to train with TCS security specialists.',
                'applied_at' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($applicationsData as $appData) {
            $student = $students[$appData['student']] ?? null;
            $internship = $internships[$appData['internship']] ?? null;

            if ($student && $internship) {
                Application::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'internship_id' => $internship->id,
                    ],
                    [
                        'cover_letter' => $appData['cover_letter'],
                        'status' => $appData['status'],
                        'applied_at' => $appData['applied_at'],
                        'created_at' => $appData['applied_at'],
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }

        // 7. Admin Notifications
        $notifications = [
            [
                'id' => Str::uuid()->toString(),
                'type' => 'App\\Notifications\\NewApplicationSubmitted',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'title' => 'New Application Received',
                    'message' => 'Aarav Sharma applied for Flutter Mobile App Developer Intern at Razorpay.',
                    'link' => route('admin.applications'),
                    'icon' => 'bi-file-earmark-person',
                    'color' => 'primary',
                ]),
                'read_at' => null,
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'id' => Str::uuid()->toString(),
                'type' => 'App\\Notifications\\NewCompanyRegistered',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'title' => 'New Partner Registered',
                    'message' => 'Zomato Ltd has registered as an official hiring partner.',
                    'link' => route('admin.companies'),
                    'icon' => 'bi-building-check',
                    'color' => 'success',
                ]),
                'read_at' => null,
                'created_at' => Carbon::now()->subHours(8),
                'updated_at' => Carbon::now()->subHours(8),
            ],
            [
                'id' => Str::uuid()->toString(),
                'type' => 'App\\Notifications\\NewInternshipPosted',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'title' => 'New Internship Posted',
                    'message' => 'Google India published "Full Stack Web Engineering Intern" (₹45,000/mo).',
                    'link' => route('admin.internships'),
                    'icon' => 'bi-briefcase',
                    'color' => 'info',
                ]),
                'read_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($notifications as $n) {
            DB::table('notifications')->updateOrInsert(
                ['id' => $n['id']],
                $n
            );
        }

        // Seed Initial Activity & Visitor Logs if empty
        if (DB::table('activity_logs')->count() === 0) {
            $initialLogs = [
                [
                    'user_id' => $admin->id,
                    'user_name' => $admin->name,
                    'user_email' => $admin->email,
                    'user_role' => 'admin',
                    'ip_address' => '103.21.124.89',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                    'device' => 'Windows • Chrome',
                    'url' => url('/admin/dashboard'),
                    'method' => 'GET',
                    'action' => 'Viewed Admin Dashboard',
                    'created_at' => Carbon::now()->subMinutes(12),
                    'updated_at' => Carbon::now()->subMinutes(12),
                ],
                [
                    'user_id' => null,
                    'user_name' => 'Recruiter / Visitor',
                    'user_email' => 'visitor@linkedin',
                    'user_role' => 'guest',
                    'ip_address' => '49.36.172.45',
                    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Safari/605.1.15',
                    'device' => 'macOS • Safari',
                    'url' => url('/admin/login'),
                    'method' => 'GET',
                    'action' => 'Visited Admin Login',
                    'created_at' => Carbon::now()->subMinutes(35),
                    'updated_at' => Carbon::now()->subMinutes(35),
                ],
                [
                    'user_id' => $admin->id,
                    'user_name' => $admin->name,
                    'user_email' => $admin->email,
                    'user_role' => 'admin',
                    'ip_address' => '103.21.124.89',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                    'device' => 'Windows • Chrome',
                    'url' => url('/admin/reports'),
                    'method' => 'GET',
                    'action' => 'Viewed Reports & Analytics',
                    'created_at' => Carbon::now()->subHours(1)->subMinutes(15),
                    'updated_at' => Carbon::now()->subHours(1)->subMinutes(15),
                ],
                [
                    'user_id' => null,
                    'user_name' => 'Guest Visitor',
                    'user_email' => 'guest@mobile',
                    'user_role' => 'guest',
                    'ip_address' => '157.34.18.92',
                    'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/124.0.6367.88 Mobile/15E148 Safari/604.1',
                    'device' => 'iOS • Chrome',
                    'url' => url('/'),
                    'method' => 'GET',
                    'action' => 'Visited Homepage / Root',
                    'created_at' => Carbon::now()->subHours(3),
                    'updated_at' => Carbon::now()->subHours(3),
                ],
                [
                    'user_id' => $admin->id,
                    'user_name' => $admin->name,
                    'user_email' => $admin->email,
                    'user_role' => 'admin',
                    'ip_address' => '103.21.124.89',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36',
                    'device' => 'Windows • Chrome',
                    'url' => url('/admin/students'),
                    'method' => 'GET',
                    'action' => 'Viewed Students Directory',
                    'created_at' => Carbon::now()->subHours(5),
                    'updated_at' => Carbon::now()->subHours(5),
                ],
            ];

            DB::table('activity_logs')->insert($initialLogs);
        }
    }
}
