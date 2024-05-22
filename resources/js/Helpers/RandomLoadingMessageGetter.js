export default class RandomLoadingMessageGetter {
    constructor(messages) {
        this.messages = [...messages];
        this.usedMessages = new Set();
    }

    getRandomMessage() {
        if (this.usedMessages.size === this.messages.length) {
            this.usedMessages.clear();
        }

        let message;
        do {
            const randomIndex = Math.floor(Math.random() * this.messages.length);
            message = this.messages[randomIndex];
        } while (this.usedMessages.has(message));

        this.usedMessages.add(message);
        return message;
    }
}
