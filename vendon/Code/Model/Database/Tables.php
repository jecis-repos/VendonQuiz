<?php

declare(strict_types=1);

namespace Vendon\Code\Model\Database;

class Tables
{
    /**
     * @return string
     */
    public static function users(): string
    {
        return 'CREATE TABLE users
        (
            user_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL UNIQUE,
            INDEX (name)
        );';
    }

    /**
     * @return string
     */
    public static function quizes(): string
    {
        return 'CREATE TABLE quizes
        (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            INDEX (name)
        );';
    }

    /**
     * @return string
     */
    public static function questions(): string
    {
        return 'CREATE TABLE questions
        (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            quiz_id INT NOT NULL,
            question TEXT NOT NULL,
            INDEX (quiz_id),
            FOREIGN KEY (quiz_id) REFERENCES quizes(id) ON DELETE CASCADE
        );';
    }

    /**
     * @return string
     */
    public static function answers(): string
    {
        return 'CREATE TABLE answers
        (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            question_id INT NOT NULL,
            answer TEXT NOT NULL,
            is_correct BOOLEAN NOT NULL,
            INDEX (question_id),
            FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
        );';
    }

    /**
     * @return string
     */
    public static function scores(): string
    {
        return 'CREATE TABLE scores
        (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            quiz_id INT NOT NULL,
            score INT NOT NULL,
            INDEX (user_id),
            INDEX (quiz_id)
        );';
    }
}
