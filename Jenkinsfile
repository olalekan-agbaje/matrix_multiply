pipeline {
    agent {
        label 'vagrant'
    }
    stages {
        stage('Build'){
            steps {
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'cp .env .env.testing'
                sh 'touch database/database.sqlite'
                sh 'php artisan migrate'
            }
        }
        stage("Feature tests") {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
