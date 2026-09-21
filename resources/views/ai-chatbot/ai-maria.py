#!/usr/bin/env python3
"""Maria AI assistant for SkillUp.

A friendly career and learning assistant that can:
- answer common student questions
- recommend TESDA-aligned courses and pathways
- operate in interactive chat mode
- use OpenRouter when an API key is configured
- fall back to a built-in local assistant if no API key is available
"""

from __future__ import annotations

import json
import os
import sys
from urllib import error, request


DEFAULT_MODEL = os.getenv("OPENROUTER_MODEL", "openai/gpt-4o-mini")
DEFAULT_SYSTEM_PROMPT = (
    "You are Maria, a friendly career guidance assistant for SkillUp. "
    "Help users choose courses, discover skills, and plan a practical learning path. "
    "Keep answers short, encouraging, and clear. Focus on TESDA-aligned training and "
    "career readiness for Filipino learners."
)


class MariaBot:
    def __init__(self, name: str = "Maria", profile: dict | None = None):
        self.name = name
        self.profile = profile or {}
        self.api_key = os.getenv("OPENROUTER_API_KEY") or os.getenv("OPENAI_API_KEY")

    def answer(self, message: str) -> str:
        cleaned = (message or "").strip()
        if not cleaned:
            return "I’m ready to help. Ask me about courses, skills, or career paths."

        if self.api_key:
            try:
                return self._call_openrouter(cleaned)
            except Exception:
                pass

        return self._generate_local_response(cleaned)

    def _call_openrouter(self, message: str) -> str:
        payload = {
            "model": DEFAULT_MODEL,
            "temperature": 0.7,
            "max_tokens": 500,
            "messages": [
                {"role": "system", "content": DEFAULT_SYSTEM_PROMPT},
                {
                    "role": "user",
                    "content": self._build_profile_context() + "\n\nUser question: " + message,
                },
            ],
        }

        body = json.dumps(payload).encode("utf-8")
        api_url = "https://openrouter.ai/api/v1/chat/completions"
        headers = {
            "Authorization": f"Bearer {self.api_key}",
            "Content-Type": "application/json",
            "HTTP-Referer": "https://skillup.local",
            "X-Title": "Maria AI Assistant",
        }

        req = request.Request(api_url, data=body, headers=headers, method="POST")
        with request.urlopen(req, timeout=30) as response:
            data = json.loads(response.read().decode("utf-8"))

        choices = data.get("choices") or []
        if not choices:
            raise ValueError("No response content returned by OpenRouter")

        content = choices[0].get("message", {}).get("content")
        if not content:
            raise ValueError("OpenRouter response content is empty")
        return str(content).strip()

    def _build_profile_context(self) -> str:
        if not self.profile:
            return "User profile: not provided."

        interests = self.profile.get("interests") or self.profile.get("interest") or "not specified"
        skill_level = self.profile.get("skill_level") or self.profile.get("experience") or "not specified"
        goals = self.profile.get("goals") or "not specified"
        return (
            f"User profile: interests={interests}; skill level={skill_level}; goals={goals}"
        )

    def _generate_local_response(self, message: str) -> str:
        text = message.lower().strip()

        if self._contains_any(text, ["hello", "hi", "hey", "good morning", "good afternoon", "good evening"]):
            return (
                "Hi! I’m Maria, your SkillUp learning assistant. I can help you choose a course, "
                "build skills, and plan a career path. What would you like to explore today?"
            )

        if self._contains_any(text, ["your name", "who are you", "what are you"]):
            return (
                "I’m Maria, a friendly AI learning assistant designed to help students discover courses, \
                improve skills, and map out career opportunities. I can recommend practical learning paths based on your interests."
            )

        if self._contains_any(text, ["tesda", "course", "program", "training", "learn"]):
            return self._course_response(text)

        if self._contains_any(text, ["career", "job", "work", "employment", "future"]):
            return self._career_response(text)

        if self._contains_any(text, ["skill", "skills", "improve", "develop"]):
            return self._skills_response(text)

        if self._contains_any(text, ["computer", "it", "tech", "programming", "coding", "software"]):
            return (
                "If you’re interested in tech, good options include Computer Systems Servicing NC II, \
                Digital Literacy, or basic programming courses. Start with foundational skills, then build a portfolio and practice with real projects."
            )

        if self._contains_any(text, ["cook", "food", "restaurant", "bakes", "culinary"]):
            return (
                "Cookery NC II is a strong choice if you enjoy food service and hospitality. It covers basic food preparation, kitchen operations, and workplace standards. This can lead to jobs in restaurants, catering, and food production."
            )

        if self._contains_any(text, ["car", "automotive", "mechanic", "repair"]):
            return (
                "Automotive Servicing NC I or NC II can be a great path if you enjoy hands-on work. These courses teach vehicle maintenance, troubleshooting, and repair basics."
            )

        if self._contains_any(text, ["construction", "electrical", "wiring", "builder", "masonry"]):
            return (
                "For construction or electrical work, consider Electrical Installation and Maintenance NC II or related trade courses. These focus on safe installation, maintenance, and practical job-readiness."
            )

        if self._contains_any(text, ["help", "how", "what can you do"]):
            return (
                "I can help you choose a course, explain the best path for your interests, suggest skills to develop, and guide you toward job-ready learning. Just tell me what you want to do or what you enjoy."
            )

        if self._contains_any(text, ["thanks", "thank you"]):
            return "You’re welcome! I’m here whenever you want to plan your next learning step."

        return (
            "I can help with skill-building, course recommendations, and career direction. Tell me your interests, your current level, or the kind of work you want to do, and I’ll suggest a practical path."
        )

    def _course_response(self, text: str) -> str:
        recommendations = [
            "If you want a practical path, start by identifying what you enjoy doing most—tech, food, automotive, construction, or customer service.",
            "A good beginner route is to choose one short TESDA-aligned course, gain hands-on practice, and then build a skill portfolio.",
            "Examples include Computer Systems Servicing NC II, Cookery NC II, and Electrical Installation and Maintenance NC II.",
        ]
        if self._contains_any(text, ["tech", "computer", "coding", "programming", "digital"]):
            return (
                "For tech, Computer Systems Servicing NC II is a strong starting point. It teaches hardware, software, troubleshooting, and basic digital support skills that are useful in many entry-level IT jobs."
            )
        if self._contains_any(text, ["food", "cook", "restaurant", "culinary"]):
            return (
                "For food and hospitality, Cookery NC II is a practical choice. It covers food preparation, kitchen safety, and service standards, which can lead to roles in restaurants, cafés, and catering services."
            )
        if self._contains_any(text, ["car", "automotive", "repair"]):
            return (
                "For automotive work, Automotive Servicing NC I or NC II is a smart path. It gives you a foundation in vehicle maintenance, diagnosis, and workshop procedures."
            )
        return " ".join(recommendations)

    def _career_response(self, text: str) -> str:
        if self._contains_any(text, ["it", "tech", "computer", "software"]):
            return (
                "A tech career path often starts with digital literacy, troubleshooting, and basic IT support skills. From there, you can move toward computer servicing, web design, or software-related roles."
            )
        if self._contains_any(text, ["food", "cook", "restaurant", "service"]):
            return (
                "A food-service career path can begin with kitchen skills, customer service, and food safety knowledge. This can lead to work in restaurants, cafés, resorts, and catering."
            )
        return (
            "The best career path is the one that matches your interests and your readiness to learn. Choose a field you enjoy, build practical skills, and look for training or entry-level jobs that let you gain experience quickly."
        )

    def _skills_response(self, text: str) -> str:
        return (
            "To improve your skills, focus on one area at a time, practice regularly, and match your learning to real work tasks. For example, improve communication, technical basics, problem-solving, and time management before trying advanced courses."
        )

    @staticmethod
    def _contains_any(text: str, keywords: list[str]) -> bool:
        return any(keyword in text for keyword in keywords)


def run_chat_loop() -> None:
    bot = MariaBot(name="Maria")
    print("Maria AI Assistant")
    print("Type 'exit' or 'quit' to end the conversation.\n")

    while True:
        try:
            user_input = input("You: ").strip()
        except KeyboardInterrupt:
            print("\nGoodbye!")
            return

        if user_input.lower() in {"exit", "quit", "bye"}:
            print("Maria: Goodbye! See you again soon.")
            return

        response = bot.answer(user_input)
        print(f"Maria: {response}\n")


def main() -> int:
    if len(sys.argv) > 1 and sys.argv[1] in {"--help", "-h"}:
        print("Usage: python ai-maria.py")
        print("Set OPENROUTER_API_KEY or OPENAI_API_KEY to enable AI-powered responses.")
        return 0

    run_chat_loop()
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
