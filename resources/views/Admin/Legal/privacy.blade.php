@extends('layout.Admin.system')

@section('title', 'Privacy Policy - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Privacy Policy</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">Privacy Policy</span>
                </nav>
            </div>
            <div class="p-3 bg-cyan-100 rounded-lg">
                <i class="fas fa-shield-alt text-cyan-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        {{-- Hero Banner --}}
        <div class="bg-gradient-to-rfrom-blue-800 to-blue-900 rounded-xl p-8 mb-10 text-white">
            <div class="flex items-start gap-5">
                <div class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-shield-alt text-2xl text-cyan-300"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">Admin Privacy Policy</h2>
                    <p class="text-blue-200 text-sm leading-relaxed">
                        This policy explains how SkillUp collects, uses, and protects information related to
                        administrators and the data you manage on the platform.
                    </p>
                    <p class="text-blue-300 text-xs mt-3">Last updated: April 2, 2026</p>
                </div>
            </div>
        </div>

        {{-- Table of Contents --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 mb-10">
            <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wide">
                <i class="fas fa-list-ul text-cyan-600 mr-2"></i>Table of Contents
            </h3>
            <ol class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-cyan-700 list-decimal list-inside">
                <li><a href="#data-collected" class="hover:text-cyan-900 hover:underline">Data Collected</a></li>
                <li><a href="#how-we-use" class="hover:text-cyan-900 hover:underline">How We Use Your Data</a></li>
                <li><a href="#data-access" class="hover:text-cyan-900 hover:underline">Access to User Data</a></li>
                <li><a href="#data-security" class="hover:text-cyan-900 hover:underline">Data Security</a></li>
                <li><a href="#data-retention" class="hover:text-cyan-900 hover:underline">Data Retention</a></li>
                <li><a href="#your-rights" class="hover:text-cyan-900 hover:underline">Your Rights</a></li>
                <li><a href="#cookies" class="hover:text-cyan-900 hover:underline">Cookies & Sessions</a></li>
                <li><a href="#changes" class="hover:text-cyan-900 hover:underline">Policy Changes</a></li>
                <li><a href="#contact" class="hover:text-cyan-900 hover:underline">Contact</a></li>
            </ol>
        </div>

        {{-- Sections --}}
        <div class="space-y-10">

            {{-- 1. Data Collected --}}
            <div id="data-collected" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">1</span>
                    <h2 class="text-xl font-bold text-gray-800">Data Collected</h2>
                </div>
                <div class="text-gray-600 leading-relaxed space-y-3 text-sm pl-13">
                    <p>When you use the SkillUp Admin Panel, we collect the following information:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                        <div class="bg-cyan-50 border border-cyan-100 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2"><i class="fas fa-user text-cyan-600 mr-2"></i>Account Information</h4>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>Full name and username</li>
                                <li>Email address</li>
                                <li>Hashed password</li>
                                <li>Role and permissions</li>
                                <li>Profile image</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2"><i class="fas fa-chart-line text-blue-600 mr-2"></i>Activity Logs</h4>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li>Login timestamps and IP addresses</li>
                                <li>Admin actions (user edits, deletions)</li>
                                <li>System configuration changes</li>
                                <li>Error logs and diagnostics</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. How We Use --}}
            <div id="how-we-use" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">2</span>
                    <h2 class="text-xl font-bold text-gray-800">How We Use Your Data</h2>
                </div>
                <ul class="space-y-3 text-sm text-gray-600 pl-13">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-cyan-500 mt-0.5 shrink-0"></i>
                        <span>Authenticate your admin session and maintain secure access to the control panel.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-cyan-500 mt-0.5 shrink-0"></i>
                        <span>Audit administrative actions for accountability, security investigations, and compliance.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-cyan-500 mt-0.5 shrink-0"></i>
                        <span>Send important system notifications (critical alerts, password resets, policy updates).</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-cyan-500 mt-0.5 shrink-0"></i>
                        <span>Improve platform stability and resolve technical issues using diagnostic logs.</span>
                    </li>
                </ul>
            </div>

            {{-- 3. Access to User Data --}}
            <div id="data-access" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">3</span>
                    <h2 class="text-xl font-bold text-gray-800">Access to User Data</h2>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed space-y-3 pl-13">
                    <p>As an admin, you have access to personally identifiable information (PII) of learners including names, emails, enrollment records, and quiz scores. You agree to:</p>
                    <ul class="space-y-2 mt-2">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-lock text-cyan-500 mt-0.5 shrink-0"></i>
                            <span>Access user data only for legitimate platform management purposes.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-lock text-cyan-500 mt-0.5 shrink-0"></i>
                            <span>Not share, export, or use user data for any unauthorized purpose.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-lock text-cyan-500 mt-0.5 shrink-0"></i>
                            <span>Report any suspected data breach or unauthorized access immediately.</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- 4. Data Security --}}
            <div id="data-security" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">4</span>
                    <h2 class="text-xl font-bold text-gray-800">Data Security</h2>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed space-y-3 pl-13">
                    <p>We implement multiple layers of security to protect admin and user data:</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                            <i class="fas fa-key text-cyan-500 text-2xl mb-2"></i>
                            <p class="font-semibold text-gray-700 text-sm">Bcrypt Hashing</p>
                            <p class="text-xs text-gray-500 mt-1">All passwords are stored using bcrypt, never in plain text.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                            <i class="fas fa-shield-halved text-cyan-500 text-2xl mb-2"></i>
                            <p class="font-semibold text-gray-700 text-sm">CSRF Protection</p>
                            <p class="text-xs text-gray-500 mt-1">All state-changing requests are protected with CSRF tokens.</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                            <i class="fas fa-database text-cyan-500 text-2xl mb-2"></i>
                            <p class="font-semibold text-gray-700 text-sm">Prepared Statements</p>
                            <p class="text-xs text-gray-500 mt-1">Database queries use parameterized statements to prevent SQL injection.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. Data Retention --}}
            <div id="data-retention" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">5</span>
                    <h2 class="text-xl font-bold text-gray-800">Data Retention</h2>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed space-y-3 pl-13">
                    <p>Admin account data is retained for as long as your account is active. Upon termination of admin access:</p>
                    <ul class="space-y-2 mt-2">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-cyan-400 text-xs mt-1.5 shrink-0"></i>
                            <span>Your account may be soft-deleted and moved to the archive for a retention period.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-cyan-400 text-xs mt-1.5 shrink-0"></i>
                            <span>Activity audit logs are retained for security and compliance purposes.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-cyan-400 text-xs mt-1.5 shrink-0"></i>
                            <span>System logs are automatically pruned after 90 days.</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- 6. Your Rights --}}
            <div id="your-rights" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">6</span>
                    <h2 class="text-xl font-bold text-gray-800">Your Rights</h2>
                </div>
                <div class="text-sm text-gray-600 leading-relaxed space-y-2 pl-13">
                    <p>As an admin, you have the right to:</p>
                    <ul class="space-y-2 mt-2">
                        <li class="flex items-start gap-3"><i class="fas fa-check text-cyan-500 mt-0.5 shrink-0"></i><span>Access and update your own profile information via <a href="{{ route('admin.profile') }}" class="text-cyan-600 underline">Admin Profile</a>.</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-check text-cyan-500 mt-0.5 shrink-0"></i><span>Request correction of inaccurate personal data held about you.</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-check text-cyan-500 mt-0.5 shrink-0"></i><span>Request deletion of your account by contacting the platform owner.</span></li>
                    </ul>
                </div>
            </div>

            {{-- 7. Cookies --}}
            <div id="cookies" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">7</span>
                    <h2 class="text-xl font-bold text-gray-800">Cookies & Sessions</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed pl-13">
                    The admin panel uses a secure, HTTP-only session cookie to maintain your login state.
                    No third-party tracking cookies are present in the admin interface. Session data is
                    encrypted and stored server-side. Sessions expire after a period of inactivity as
                    configured in the platform security settings.
                </p>
            </div>

            {{-- 8. Changes --}}
            <div id="changes" class="scroll-mt-24 bg-white border border-gray-100 rounded-xl shadow-sm p-7">
                <div class="flex items-center mb-5">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">8</span>
                    <h2 class="text-xl font-bold text-gray-800">Policy Changes</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed pl-13">
                    We may update this Privacy Policy from time to time. Major changes will be communicated
                    via the admin dashboard notification system or by email. Continued use of the admin panel
                    after changes constitutes your acceptance of the revised policy.
                </p>
            </div>

            {{-- 9. Contact --}}
            <div id="contact" class="scroll-mt-24 bg-cyan-50 border border-cyan-200 rounded-xl p-7">
                <div class="flex items-center mb-4">
                    <span class="w-9 h-9 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4 shrink-0">9</span>
                    <h2 class="text-xl font-bold text-gray-800">Contact</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed pl-13 mb-4">
                    For privacy-related inquiries, data access requests, or to report a security concern, please contact
                    the platform owner or use the admin support chat.
                </p>
                <div class="pl-13">
                    <a href="{{ route('admin.chats.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition">
                        <i class="fas fa-comment-alt"></i> Open Support Chat
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
