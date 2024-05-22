import './bootstrap';
import services from'./Services/index.js'
import RandomLoadingMessageGetter from "./Helpers/RandomLoadingMessageGetter.js";
import RandomValues from "./Helpers/RandomValues.js";

window.forms = {}

window.forms.validations = {}

window.forms.checkValidations = () => {
    if (Object.keys(window.forms.validations).length === 0) {
        return false
    }

    for (const key in window.forms.validations) {
        if (!window.forms.validations[key]) {
            return false
        }
    }

    return true
};

document.addEventListener('DOMContentLoaded', () => {
    window.services = services;
    window.helpers = {
        Random: RandomValues,
    }
    window.loadingMessages = new RandomLoadingMessageGetter([
        "Optimizing your website speed...",
        "Analyzing best practices...",
        "Improving your page accessibility...",
        "Evaluating PWA performance...",
        "Reviewing SEO optimization...",
        "Measuring your site's efficiency...",
        "Checking compliance with best practices...",
        "Analyzing mobile usability...",
        "Optimization in progress, please wait...",
        "Evaluating load times...",
        "Checking PWA compatibility...",
        "Enhancing user experience...",
        "Evaluating accessibility and navigation...",
        "Analyzing site structure...",
        "Reviewing technical SEO elements...",
        "SEO is crucial for ranking higher on search engines.",
        "Fast load times improve user retention and satisfaction.",
        "Accessible websites reach a wider audience.",
        "PWA features enhance user engagement.",
        "Good SEO increases organic traffic.",
        "Efficient resource usage boosts performance.",
        "Mobile-friendly sites are preferred by users.",
        "Best practices improve site reliability and security.",
        "JavaScript performance impacts loading speed.",
        "Effective caching reduces server load.",
        "Optimized images enhance load times.",
        "Technical SEO helps search engines understand your site.",
        "Improving navigation boosts user experience.",
        "Responsive design is key for mobile users.",
        "Server response time affects page speed.",
        "SEO helps search engines understand your content.",
        "Page speed impacts conversion rates.",
        "Accessibility compliance can prevent legal issues.",
        "PWA allows offline functionality for users.",
        "Meta tags are important for SEO.",
        "Minimizing redirects improves site speed.",
        "Alt text improves image SEO and accessibility.",
        "Clean code helps maintain site performance.",
        "Reducing HTTP requests speeds up load times.",
        "HTTPS improves security and SEO rankings.",
        "Well-structured URLs improve user experience.",
        "Evaluating best development practices...",
        "Measuring site interactivity...",
        "Checking mobile adaptability...",
        "Analyzing server response times...",
        "Improving PageSpeed score...",
        "Verifying web accessibility...",
        "Checking use of PWA technologies...",
        "Reviewing on-page SEO...",
        "Optimizing images and resources...",
        "Measuring cache effectiveness...",
        "Analyzing HTML structure...",
        "Checking browser compatibility..."
    ]);
});

