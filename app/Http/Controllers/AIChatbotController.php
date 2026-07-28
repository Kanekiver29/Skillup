<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\GeminiService;

class AIChatbotController extends Controller
{
    private GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }
    /**
     * Display the AI chatbot interface
     */
    public function index()
    {
        return view('ai-chatbot.index');
    }

    /**
     * Send a message to the AI and get a response
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $validated['message'];
        $user = auth()->user();

        $aiResponse = $this->callGemini($userMessage, $user)
            ?? $this->callOpenRouter($userMessage, $user);

        if (! $aiResponse) {
            $aiResponse = $this->generateLocalAIResponse($userMessage);
            Log::warning('AIChatbotController falling back to local response.', [
                'message' => $userMessage,
                'geminiConfigured' => $this->geminiService->isConfigured(),
                'openRouterConfigured' => !empty(env('OPENROUTER_API_KEY')),
            ]);
        }

        return response()->json([
            'success' => true,
            'userMessage' => $userMessage,
            'aiResponse' => $aiResponse,
        ]);
    }

    /**
     * Call OpenRouter chat completions API if API key is configured.
     * Tries gpt-4o-mini first, falls back to mistral-7b-instruct for cost optimization.
     * Includes user profile context for personalized guidance.
     */
    private function callGemini(string $message, $user = null): ?string
    {
        return $this->geminiService->generateResponse($message, $user);
    }

    private function callOpenRouter(string $message, $user = null): ?string
    {
        $apiKey = env('OPENROUTER_API_KEY');
        if (!$apiKey) {
            return null;
        }

        $systemPrompt = 'You are SkillUp, a career guidance assistant focused on TESDA programs in the Philippines. Your job is to help users: - Identify their interests and skills - Recommend TESDA courses (NC I, NC II, etc.) - Suggest practical career paths - Guide beginners step-by-step Guidelines: - Always ask 1–2 follow-up questions before giving recommendations - Keep answers simple, clear, and friendly - Avoid long explanations - Focus on real TESDA courses such as: - Computer Systems Servicing NC II - Cookery NC II - Automotive Servicing NC I - Electrical Installation and Maintenance NC II - If the user is unsure, suggest options and guide them Conversation Style: - Friendly and conversational - Short paragraphs - Practical advice, not theory Goal: Help the user choose a TESDA course and When recommending: 1. Match user interest to TESDA category 2. Suggest 1–2 courses only 3. Explain briefly what the course teaches 4. Ask if they want training centers nearby';

        // Build messages array with profile context
        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        // Add user profile context if available
        if ($user) {
            $profile = $user->profile;
            $profileContext = 'User Profile: ';
            if ($profile) {
                $profileContext .= 'Interest = ' . ($profile->interest ?? 'Not specified') . ', Skill Level = ' . ($profile->skill_level ?? 'Not specified');
            } else {
                $profileContext .= 'Interest = Not specified, Skill Level = Not specified';
            }
            $messages[] = ['role' => 'system', 'content' => $profileContext];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        // Prefer OpenAI GPT-4 for best guidance, then cost-optimize with gpt-4o-mini, then fallback to Mistral.
        $models = ['openai/gpt-4', 'gpt-4o-mini', 'mistralai/mistral-7b-instruct'];

        foreach ($models as $model) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json',
                ])->timeout(20)->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 500,
                ]);

                if ($response->successful() && isset($response['choices'][0]['message']['content'])) {
                    return trim($response['choices'][0]['message']['content']);
                }
            } catch (\Exception $exception) {
                // Try next model if available
                continue;
            }
        }

        return null;
    }

    /**
     * Generate AI response based on keywords and knowledge base
     * Enhanced with domain-specific knowledge about SkillUp courses
     */
    private function generateLocalAIResponse(string $message): string
    {
        $message = strtolower($message);

        // General conversational responses
        if ($this->isGreeting($message)) {
            return $this->getGreetingResponse();
        }

        if ($this->isPersonalQuestion($message)) {
            return $this->getPersonalResponse($message);
        }

        if ($this->isGeneralQuestion($message)) {
            return $this->getGeneralResponse($message);
        }

        // Course-specific responses
        if ($this->containsCourseKeywords($message, 'critical thinking')) {
            return $this->getCriticalThinkingResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'digital communication')) {
            return $this->getDigitalCommunicationResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'creativity')) {
            return $this->getCreativityResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'sustainable farming')) {
            return $this->getSustainableFarmingResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'precision agriculture')) {
            return $this->getPrecisionAgricultureResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'automotive')) {
            return $this->getAutomotiveResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'electric vehicle')) {
            return $this->getEVResponse($message);
        }

        if ($this->containsCourseKeywords($message, 'construction')) {
            return $this->getConstructionResponse($message);
        }

        // Career guidance responses
        if (strpos($message, 'career') !== false || strpos($message, 'job') !== false) {
            return $this->getCareerAdvice($message);
        }

        // Course recommendation
        if (strpos($message, 'course') !== false || strpos($message, 'learn') !== false) {
            return $this->getCourseRecommendation($message);
        }

        // Skills related
        if (strpos($message, 'skill') !== false || strpos($message, 'develop') !== false) {
            return $this->getSkillsAdvice($message);
        }

        // General motivation
        if (strpos($message, 'motivation') !== false || strpos($message, 'inspire') !== false) {
            return $this->getMotivation();
        }

        // Help and navigation
        if (strpos($message, 'help') !== false || strpos($message, 'how') !== false) {
            return $this->getHelpResponse($message);
        }

        // Default helpful response - now more comprehensive
        return $this->getComprehensiveDefaultResponse($message);
    }

    private function containsCourseKeywords(string $message, string $courseName): bool
    {
        $keywords = explode(' ', $courseName);
        foreach ($keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isGreeting(string $message): bool
    {
        $greetings = ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'greetings', 'howdy'];
        foreach ($greetings as $greeting) {
            if (strpos($message, $greeting) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isPersonalQuestion(string $message): bool
    {
        $personal = ['your name', 'who are you', 'what are you', 'how are you', 'how old are you', 'where are you'];
        foreach ($personal as $question) {
            if (strpos($message, $question) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isGeneralQuestion(string $message): bool
    {
        $general = ['what is', 'how does', 'why', 'when', 'where', 'which', 'can you'];
        foreach ($general as $word) {
            if (strpos($message, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    private function getGreetingResponse(): string
    {
        $responses = [
            "Hello! I'm SkillUp AI, your friendly learning and career assistant. I'm here to help you discover courses, develop skills, and achieve your professional goals. What can I help you with today?",
            "Hi there! Welcome to SkillUp! I'm your AI assistant, ready to guide you through our courses and help you build the skills you need for success. How can I assist you?",
            "Greetings! I'm SkillUp AI, designed to support your learning journey. Whether you need course recommendations, career advice, or skill development tips, I'm here to help. What would you like to know?",
        ];

        return $responses[array_rand($responses)];
    }

    private function getPersonalResponse(string $message): string
    {
        if (strpos($message, 'your name') !== false || strpos($message, 'who are you') !== false) {
            return "I'm SkillUp AI, your intelligent learning assistant! I'm here to help you navigate courses, get career advice, and develop the skills you need for success. I have knowledge about all our courses in 21st Century Skills, Agriculture, Automotive, and Construction fields.";
        }

        if (strpos($message, 'how are you') !== false) {
            return "I'm doing great, thank you for asking! I'm always ready and excited to help learners like you discover new skills and achieve their goals. How about you? What brings you to SkillUp today?";
        }

        if (strpos($message, 'how old are you') !== false) {
            return "As an AI assistant, I don't have an age in the traditional sense, but I've been helping students since SkillUp launched! I'm constantly learning and updating my knowledge to provide the best guidance possible.";
        }

        if (strpos($message, 'where are you') !== false) {
            return "I'm right here in the SkillUp platform, available 24/7 to help you with your learning journey! Whether you're studying from home, work, or anywhere else, I'm here to support you.";
        }

        return "I'm SkillUp AI, your dedicated learning companion! I'm designed to help you with course recommendations, career guidance, skill development, and anything related to your educational journey.";
    }

    private function getGeneralResponse(string $message): string
    {
        if (strpos($message, 'what is skillup') !== false) {
            return "SkillUp is a comprehensive online learning platform offering courses in 21st Century Skills, Agriculture, Automotive, and Construction. We help professionals and students develop in-demand skills for career success. With expert instructors and practical content, we're here to support your learning journey!";
        }

        if (strpos($message, 'how does') !== false && strpos($message, 'work') !== false) {
            return "SkillUp works by providing structured online courses with video lessons, quizzes, and practical assignments. You can enroll in courses, track your progress, and learn at your own pace. Our AI assistant (that's me!) is here to help you choose the right courses and stay motivated!";
        }

        if (strpos($message, 'why') !== false && strpos($message, 'skillup') !== false) {
            return "SkillUp exists to bridge the gap between education and career success. We offer practical, industry-relevant courses taught by experts, helping you develop skills that employers actually want. Our platform is designed to make learning accessible, engaging, and effective for everyone.";
        }

        if (strpos($message, 'when') !== false) {
            return "SkillUp courses are available 24/7, so you can learn whenever it fits your schedule! Whether you're a night owl or an early bird, our platform is always ready. Most courses can be completed in weeks to months, depending on your pace and the course length.";
        }

        if (strpos($message, 'can you') !== false) {
            return "Yes, I can help! As SkillUp AI, I can: recommend courses based on your goals, provide career advice, explain course content, help with skill development strategies, answer questions about our platform, and offer motivation and study tips. What would you like assistance with?";
        }

        return "That's a great question! While I specialize in learning and career development, I can connect your interests to relevant courses or skills. For example, if you're asking about " . substr($message, 0, 20) . "..., I can help you find courses that might relate to that topic. What specific area are you interested in exploring?";
    }

    private function getCourseRecommendation(string $message): string
    {
        if (strpos($message, 'web') !== false || strpos($message, 'development') !== false) {
            return "Great! Web development is a high-demand field. We offer courses covering HTML, CSS, JavaScript, React, Laravel, and more. Start with our 'Web Development Fundamentals' course to build a solid foundation.";
        }

        if (strpos($message, 'business') !== false || strpos($message, 'entrepreneurship') !== false) {
            return "Interested in business? Our Entrepreneurship and Small Business Management courses teach you how to start and scale a business. Perfect for aspiring entrepreneurs!";
        }

        if (strpos($message, 'data') !== false || strpos($message, 'analytics') !== false) {
            return "Data is the future! Check out our Data Analysis and Business Intelligence courses. Learn to work with Python, SQL, and tools that companies use daily.";
        }

        if (strpos($message, 'agriculture') !== false || strpos($message, 'farming') !== false) {
            return "Agriculture is evolving! Our courses cover Sustainable Farming Practices and Precision Agriculture with Technology. Whether you're a farmer or interested in agtech, we have courses for all levels.";
        }

        if (strpos($message, 'automotive') !== false || strpos($message, 'car') !== false) {
            return "The automotive industry needs skilled professionals! Check out our Automotive Maintenance and Repair course, or dive into Electric Vehicle Technology for the future of transportation.";
        }

        if (strpos($message, 'construction') !== false || strpos($message, 'building') !== false) {
            return "Construction management is a stable and rewarding career. Our Construction Management Essentials course covers project planning, safety, and team management.";
        }

        return "SkillUp offers courses across multiple categories: 21st Century Skills (Critical Thinking, Digital Communication, Creativity), Agriculture (Sustainable Farming, Precision Agriculture), Automotive (Maintenance, Electric Vehicles), and Construction Management. What interests you most, or tell me about your career goals and I'll recommend the perfect course!";
    }

    private function getSkillsAdvice(string $message): string
    {
        $responses = [
            "Building skills takes commitment and practice. We recommend: 1) Choose a skill to focus on 2) Take structured courses 3) Practice regularly 4) Build projects 5) Get feedback from mentors.",
            "The most in-demand skills today are: Technical skills (programming, data analysis, cloud tech), Soft skills (communication, leadership, problem-solving), and Creative skills (design, content creation). Which area interests you?",
            "Don't try to learn everything at once. Pick one skill, master it, then move to the next. Our structured learning paths will guide you step-by-step.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getMotivation(): string
    {
        $responses = [
            "Remember, every expert was once a beginner. You're taking the right step by investing in your education. Stay consistent, and you'll see amazing results!",
            "Your future is being created today by the choices you make. Every course you complete, every skill you develop, brings you closer to your dreams.",
            "Don't compare your beginning to someone else's middle. Focus on your own progress. With SkillUp, you have everything you need to succeed.",
            "The fact that you're here learning shows you have ambition and drive. That's the first ingredient for success. Keep going!",
        ];

        return $responses[array_rand($responses)];
    }

    private function getCriticalThinkingResponse(string $message): string
    {
        $responses = [
            "Critical Thinking and Problem Solving is one of our most popular 21st Century Skills courses! Taught by Dr. James Peterson, this 30-hour course covers problem-solving frameworks, logical reasoning, and decision-making skills. The course includes modules on fundamentals, intermediate concepts, and practical applications. What aspect of critical thinking interests you most - problem-solving techniques, logical reasoning, or decision-making frameworks?",
            "Our Critical Thinking course is designed for professionals in any field. You'll learn to analyze complex problems, evaluate information sources, and develop innovative solutions. Students rate it 4.7 stars! The course includes hands-on exercises and real-world case studies. Are you looking to improve your analytical skills for work, or do you have a specific problem you'd like to learn how to solve?",
            "Critical thinking is essential for career success. In this course, you'll master techniques like root cause analysis, logical fallacies identification, and creative problem-solving. The course is structured with 4 modules: Fundamentals & Basics, Intermediate Concepts, Advanced Techniques, and Practical Applications. What's your current level of experience with critical thinking, and what would you like to achieve?",
        ];

        return $responses[array_rand($responses)];
    }

    private function getDigitalCommunicationResponse(string $message): string
    {
        $responses = [
            "Digital Communication and Collaboration is perfect for today's remote work environment! Led by Lisa Chen, this 25-hour course teaches virtual communication best practices and team collaboration tools. You'll learn about video conferencing, digital etiquette, and collaborative platforms. Over 7,300 students have taken this course!",
            "Master the art of digital communication with our comprehensive course. Learn how to communicate effectively in virtual meetings, manage remote teams, and use collaboration tools like Slack, Microsoft Teams, and Google Workspace. The course includes practical exercises and real workplace scenarios.",
            "In our Digital Communication course, you'll discover: Virtual presentation skills, Cross-cultural communication in digital spaces, Conflict resolution in remote teams, and Digital collaboration tools. This course is rated 4.8 stars and takes about 25 hours to complete. Interested in enrolling?",
        ];

        return $responses[array_rand($responses)];
    }

    private function getCreativityResponse(string $message): string
    {
        $responses = [
            "Creativity and Innovation is our intermediate-level course taught by Michael Torres. This 35-hour program helps you unlock your creative potential and learn innovation methodologies used by successful companies. Perfect for entrepreneurs and innovators!",
            "Want to become more creative? Our Creativity course covers brainstorming techniques, design thinking, innovation frameworks, and creative problem-solving. You'll learn from real-world examples and complete projects that build your creative portfolio.",
            "This course is designed for those ready to take their creativity to the next level. You'll explore lateral thinking, innovation processes, and how to foster creativity in teams. The course includes 4 modules and has helped over 4,500 students enhance their creative skills.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getSustainableFarmingResponse(string $message): string
    {
        $responses = [
            "Sustainable Farming Practices is our beginner-friendly agriculture course taught by Robert Martinez. Learn eco-friendly farming techniques that maximize yields while protecting the environment. This 45-hour course covers soil management, crop rotation, and organic methods.",
            "Interested in sustainable agriculture? This course teaches you how to implement farming practices that are both profitable and environmentally responsible. You'll learn about soil health, natural pest control, water conservation, and sustainable crop management.",
            "Our Sustainable Farming course is perfect for farmers, agricultural students, and anyone interested in food production. The curriculum includes hands-on lessons about composting, integrated pest management, and sustainable irrigation systems. Rated 4.5 stars by over 3,200 students!",
        ];

        return $responses[array_rand($responses)];
    }

    private function getPrecisionAgricultureResponse(string $message): string
    {
        $responses = [
            "Precision Agriculture and Technology is our intermediate course taught by Dr. Susan Park. Learn how to use modern technology like drones, sensors, and data analytics to optimize farm productivity. This 40-hour course is perfect for tech-savvy farmers!",
            "Discover the future of farming with precision agriculture! You'll learn about IoT sensors, GPS-guided equipment, drone technology, and data-driven decision making. This course combines agriculture knowledge with cutting-edge technology.",
            "In this course, you'll master technologies that are revolutionizing agriculture: Satellite imagery analysis, Automated irrigation systems, Yield monitoring, and Farm management software. Over 2,800 students have taken this course to stay ahead in modern farming.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getAutomotiveResponse(string $message): string
    {
        $responses = [
            "Automotive Maintenance and Repair is our intermediate course taught by David Johnson. This 50-hour program covers vehicle diagnostics, engine maintenance, and electrical systems. Perfect for aspiring mechanics and car enthusiasts!",
            "Learn professional automotive repair skills in this comprehensive course. You'll cover engine diagnostics, brake systems, electrical troubleshooting, and modern vehicle maintenance. The course includes both theory and practical applications.",
            "This course prepares you for a career in automotive service. You'll learn about hybrid vehicle systems, computerized diagnostics, and preventive maintenance. Rated 4.6 stars by over 4,100 students who have built successful careers in automotive repair.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getEVResponse(string $message): string
    {
        $responses = [
            "Electric Vehicle Technology is our advanced course taught by Alex Green. This 55-hour program explores EV battery systems, charging infrastructure, and the future of sustainable transportation. Perfect for those interested in green technology!",
            "Dive deep into electric vehicle technology! Learn about lithium-ion batteries, motor control systems, regenerative braking, and charging networks. This course is ideal for automotive engineers and EV enthusiasts.",
            "Our EV course covers everything from battery chemistry to autonomous driving systems. You'll understand the technical challenges and innovations driving the electric vehicle revolution. Over 3,700 students have taken this course to prepare for careers in sustainable transportation.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getConstructionResponse(string $message): string
    {
        $responses = [
            "Construction Management Essentials is our intermediate course covering project planning, safety regulations, and team management in construction. Learn the skills needed to lead successful construction projects.",
            "This course teaches you how to manage construction projects from start to finish. You'll learn about building codes, safety standards, cost estimation, and project scheduling. Essential for construction supervisors and project managers.",
            "Master the fundamentals of construction management including risk assessment, quality control, and stakeholder management. This course prepares you for leadership roles in the construction industry.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getHelpResponse(string $message): string
    {
        $responses = [
            "I'm here to help! I can assist you with: Course recommendations, Career guidance, Skill development advice, Enrollment help, Course content questions, and general learning support. What specific help do you need?",
            "SkillUp's AI assistant can help you: Find the right courses for your goals, Understand course content and requirements, Get career advice, Learn about our different subject areas (21st Century Skills, Agriculture, Automotive, Construction, etc.), and Navigate the platform. How can I assist you today?",
            "Need help navigating SkillUp? I can guide you to courses in: 21st Century Skills (Critical Thinking, Digital Communication, Creativity), Agriculture (Sustainable Farming, Precision Agriculture), Automotive (Maintenance, Electric Vehicles), and Construction Management. I can also help with enrollment, progress tracking, and learning tips.",
        ];

        return $responses[array_rand($responses)];
    }

    private function getComprehensiveDefaultResponse(string $message): string
    {
        // Try to extract key topics from the message
        $topics = ['tech', 'technology', 'programming', 'coding', 'business', 'marketing', 'design', 'art', 'science', 'math', 'writing', 'communication', 'leadership', 'management', 'finance', 'health', 'fitness', 'cooking', 'music', 'sports'];

        foreach ($topics as $topic) {
            if (strpos($message, $topic) !== false) {
                return "Interesting that you're asking about " . $topic . "! While SkillUp specializes in professional skills and career development, I can help you find related courses or suggest learning paths. For example, we have courses in 21st Century Skills that include communication and critical thinking. What specific aspect of " . $topic . " interests you most?";
            }
        }

        $responses = [
            "That's an interesting question! As your SkillUp learning assistant, I focus on helping you develop professional skills and advance your career. I can provide guidance on our courses in 21st Century Skills, Agriculture, Automotive, and Construction fields. Could you tell me more about what you're trying to learn or achieve?",
            "I appreciate you sharing that with me! While I specialize in career and skill development, I can help connect your interests to relevant learning opportunities. SkillUp offers courses that build practical skills for today's job market. What type of skills or career goals are you working towards?",
            "Thanks for your question! I'm here to support your learning journey at SkillUp. Whether you need course recommendations, study tips, career advice, or help navigating our platform, I'm ready to assist. What specific area can I help you with today?",
            "Great question! As SkillUp AI, I have extensive knowledge about our courses and can help you choose the right learning path. Our platform covers everything from critical thinking and digital communication to sustainable farming and automotive technology. What interests you most, or tell me about your career goals?",
        ];

        return $responses[array_rand($responses)];
    }
}
