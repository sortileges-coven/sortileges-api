<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class RegistrationController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {

        // Check params & return error if needed
        $constraints = new Collection([
            'password' => [new NotBlank(), new Length(['min' => 8])],
            'email' => [new NotBlank(), new Email()]
        ]);
        $parameters = ['email' => $request->get('email'), 'password' => $request->get('password')];
        $validator = Validation::createValidator();
        $errors = $validator->validate($parameters, $constraints);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $violation) {
                array_push($errorMessages, [
                    'field' => str_replace(['[', ']'], '', $violation->getPropertyPath()),
                    'message' => $violation->getMessage()
                ]);
            }
            return $this->json(["message" => "Registration failed", "errors" => $errorMessages], 400);
        }

        $email = $parameters["email"];
        $password = $parameters["password"];
        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        if (!is_null($user)) {
            return $this->json(['message' => 'User with this email already exists.'], Response::HTTP_CONFLICT);
        }

        // Fill user
        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $password
        ));


        // Persist and return
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
