<?php

require_once "Repository.php";
require_once __DIR__.'/../models/Squad.php';

class SquadRepository extends Repository
{
    public function getSquad(int $int): ?Squad
    {
        $stmt= $this->database->connect()->prepare('
            SELECT * FROM squads WHERE  id=:id 
        ');

        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $squad=$stmt->fetch(PDO::FETCH_ASSOC);

        if($squad==false){
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new Squad(
            $squad['sport'],
            $squad['noMembers'],
            $squad['fee'],
            $squad['place'],
            $squad['address']
        );

    }

    public function addSquad(Squad $squad): void
    {
        $date=new DateTime();
        $stmt=$this->database->connect()->prepare('
        INSERT INTO squads (id_squad_creator,sport,max_members,fee,created_at,date,id_place)
        VALUES(?,?,?,?,?,?,)
        ');
            //todo POBRAC TO Z SESJI A NIE KODOWANE NA SZTYWNO

        $id_squad_creator=1;


            $stmt->execute([
                $id_squad_creator,
                $squad->getSport(),
                $squad->getNoMembers(),
                $squad->getFee(),
                $date->format('Y-m-d'),
                $squad->getPlace()->getId()
            ]);
    }
}




















