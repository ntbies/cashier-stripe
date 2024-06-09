# Contributing to ntbies/cashier-stripe

First off, thanks for taking the time to contribute! :tada: :+1: The following is a set of guidelines for contributing to the `ntbies/cashier-stripe` package.

## How Can I Contribute?

### Reporting Bugs

If you encounter any bugs while using the package, please open an issue on GitHub with the following details:
- A clear and descriptive title.
- A detailed description of the problem.
- Steps to reproduce the issue.
- Any relevant code snippets or error messages.
- The versions of PHP, Laravel, and the package you are using.

### Suggesting Enhancements

We welcome suggestions for new features or improvements to existing ones. If you have an idea, please open an issue with:
- A clear and descriptive title.
- A detailed description of the enhancement.
- Any relevant code snippets or examples.

### Submitting Pull Requests

Before submitting a pull request, please ensure you have read and followed these guidelines:
1. **Fork the repository** to your own GitHub account.
2. **Clone the repository** to your local machine:
    ```sh
    git clone https://github.com/your-username/cashier-stripe.git
    ```
3. **Create a new branch** for your changes:
    ```sh
    git checkout -b feature-or-bugfix-name
    ```
4. **Install dependencies**:
    ```sh
    composer install
    ```
5. **Make your changes** in the `src` directory.
6. **Write tests** for your changes in the `tests` directory (planned for future implementation).
7. **Run tests** to ensure all tests pass (planned for future implementation):
    ```sh
    phpunit
    ```
8. **Commit your changes** with a clear commit message:
    ```sh
    git commit -m "Description of the changes"
    ```
9. **Push to your fork**:
    ```sh
    git push origin feature-or-bugfix-name
    ```
10. **Open a pull request** on GitHub, providing a clear description of your changes and the related issue (if any).

### Code Style

Please ensure your code adheres to the PSR-12 coding standard. You can use tools like PHP_CodeSniffer to check your code:
```sh
composer require --dev squizlabs/php_codesniffer
./vendor/bin/phpcs --standard=PSR12 src/
```

### Commit Messages

- Use the present tense ("Add feature" not "Added feature").
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...").
- Limit the first line to 72 characters or less.
- Reference issues and pull requests liberally.

### Getting Help

If you need help with the package, feel free to open an issue or start a discussion on GitHub.

## License

By contributing to `ntbies/cashier-stripe`, you agree that your contributions will be licensed under the [MIT License](LICENSE.md).

---

Thank you for contributing!