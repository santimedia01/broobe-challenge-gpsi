export default class RandomValues {
    static getRandomInterval (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
}
