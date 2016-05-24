<?php
declare(strict_types=1);

namespace LotGD\Core\Models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * A model representing a buff used to modify the flow of the battle.
 * @Entity
 * @Table(name="buffs")
 */
class Buff
{
    const ACTIVATE_ROUNDSTART = 0b0001;
    const ACTIVATE_ROUNDEND = 0b0010;
    const ACTIVATE_OFFENSE = 0b0100;
    const ACTIVATE_DEFENSE = 0b1000;
    const ACTIVATE_WHILEROUND = 0b1100;
    
    /** @Id @Column(type="integer") @GeneratedValue */
    private $id;
    /** 
     * @ManyToOne(targetEntity="Character", inversedBy="buffs")
     * @JoinColumn(nullable=True)
     */
    private $character;
    /** @Column(type="string") */
    private $slot;
    /**
     * Name of the buff
     * @var string
     * @Column(type="string")
     */
    private $name;
    /**
     * The message given upon activation of the buff
     * @var string
     * @Column(type="text")
     */
    private $startMessage;
    /**
     * The message given every round
     * @var string
     * @Column(type="text")
     */
    private $roundMessage;
    /**
     * The message given if the buff ends
     * @var string
     * @Column(type="text")
     */
    private $endMessage;
    /**
     * The message given if the effect has success
     * @var string
     * @Column(type="text")
     */
    private $effectSucceedsMessage;
    /**
     * The message given if the effect fails
     * @var string
     * @Column(type="text")
     */
    private $effectFailsMessage;
    /**
     * The message given if the effect has no effect
     * @var string
     * @Column(type="text")
     */
    private $noEffectMessage;
    /**
     * Message that gets displayed every new day.
     * @var string
     * @Column(type="text")
     */
    private $newDayMessage;
    /**
     * A value determining when the buffs activates
     * @var int
     * @Column(type="integer")
     */
    private $activateAt;
    /**
     * True if the buff survives a new day
     * @var bool
     * @Column(type="boolean")
     */
    private $survivesNewDay = false;
    /**
     * The number of rounds this buff lasts.
     * 
     * Gets reduces very round by 1. If the value is < 0, the buff is permament until a new day arises.
     * @var int
     * @Column(type="integer")
     */
    private $rounds = 1;
    /**
     * Number of healthpoints the badguy regenerates
     * @var int
     * @Column(type="integer")
     */
    private $badguyRegeneration = 0;
    /**
     * Number of healthpoints the goodguy regenerates
     * @var int
     * @Column(type="integer")
     */
    private $goodguyRegeneration = 0;
    /**
     * Fraction of damage applied to the badguy that gets converted to health ("absorb")
     * @var float
     * @Column(type="float")
     */
    private $badguyLifetap = 0;
    /**
     * Fraction of damage applied to the goodguy that gets converted to health
     * @var float
     * @Column(type="float")
     */
    private $goodguyLifetap = 0;
    /**
     * Fraction of damage that is reflected to the goodguy if damage is applied to the badguy
     * @var float
     * @Column(type="float")
     */
    private $badguyDamageReflection = 0;
    /**
     * Fraction of damage that is reflected to the badguy if damage is applied to the goodguy
     * @var float
     * @Column(type="float")
     */
    private $goodguyDamageReflection = 0;
    /**
     * Number of minions
     * @var int
     * @Column(type="integer")
     */
    private $numberOfMinions = 0;
    /**
     * Minium damage done to the badguy by the minions (if $numberOfMinions > 0)
     * @var int
     * @Column(type="integer")
     */
    private $minionMinBadguyDamage = 0;
    /**
     * Maximum damage done to the badguy by the minions (if $numberOfMinions > 0)
     * @var int
     * @Column(type="integer")
     */
    private $minionMaxBadguyDamage = 0;
     /**
     * Minium damage done to the goodguy by the minions (if $numberOfMinions > 0)
     * @var int
     * @Column(type="integer")
     */
    private $minionMinGoodguyDamage = 0;
    /**
     * Maximum damage done to the goodguy by the minions (if $numberOfMinions > 0)
     * @var int
     * @Column(type="integer")
     */
    private $minionMaxGoodguyDamage = 0;
    /**
     * Modifies the damage applied to the badguy.
     * @var float
     * @Column(type="float")
     */
    private $badguyDamageModifier = 1;
    /**
     * Modifies the badguy's attack value
     * @var float
     * @Column(type="float")
     */
    private $badguyAttackModifier = 1;
    /**
     * Modified the badguy's defense value
     * @var float
     * @Column(type="float")
     */
    private $badguyDefenseModifier = 1;
    /**
     * True if the badguy stays invulnurable during the buffs duration
     * @var bool
     * @Column(type="boolean")
     */
    private $badguyInvulnurable = false;
    /**
     * Modifies the damage applied to the goodguy
     * @var float
     * @Column(type="float")
     */
    private $goodguyDamageModifier = 1;
    /**
     * Modifies the goodguy's attack value
     * @var float
     * @Column(type="float")
     */
    private $goodguyAttackModifier = 1;
    /**
     * Modifies the goodguy's defense value
     * @var float
     * @Column(type="float")
     */
    private $goodguyDefenseModifier = 1;
    /**
     * True if the goodguy stays invulnurable during the buffs duration
     * @var bool
     * @Column(type="boolean")
     */
    private $goodguyInvulnurable = false;
    
    /**
     * Returns the id of the buff
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * Returns the Character this buff has been applied to
     * @return \LotGD\Core\Models\Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }
    
    /**
     * Returns the slot this buff occupies
     * @return string
     */
    public function getSlot(): string
    {
        return $this->slot;
    }
    
    /**
     * Returns the buff's name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Returns the message displayed upon buff activation
     * @return string
     */
    public function getStartMessage(): string
    {
        return $this->startMessage;
    }
    
    /**
     * Returns the message displayed every round
     * @return string
     */
    public function getRoundMessage(): string
    {
        return $this->roundMessage;
    }
    
    /**
     * Returns the message displayed upon the end of the buff's lifetime.
     * @return string
     */
    public function getEndMessage(): string
    {
        return $this->endMessage;
    }
    
    /**
     * Returns the message displayed when the buff's effect succeeds
     * @return string
     */
    public function getEffectSucceedsMessage(): string
    {
        return $this->effectSucceedsMessage;
    }
    
    /**
     * Returns the message displayed when the buff's effect fails
     * @return string
     */
    public function getEffectFailsMessage(): string
    {
        return $this->effectFailsMessage;
    }
    
    /**
     * Returns the message displayed when the buff has no effect at all
     * @return string
     */
    public function getNoEffectMessage(): string
    {
        return $this->noEffectMessage;
    }
    
    /**
     * Returns the message at the dawn of a new day.
     * @return string
     */
    public function getNewDayMessage(): string
    {
        return $this->newDayMessage;
    }
    
    /**
     * Returns the flags when this buff activates its effects.
     * @return int
     */
    public function getActivateAt(): int
    {
        return $this->activateAt;
    }
    
    /**
     * Checks if this buff gets activated
     * @param int $flag
     * @return bool
     */
    public function getsActivatedAt(int $flag): bool
    {
        return $this->activateAt & $flag;
    }
    
    /**
     * Returns true if the buff survives a new day.
     * @return bool
     */
    public function survivesNewDay(): bool
    {
        return $this->survivesNewDay;
    }

    /**
     * Returns the number of rounds left
     * @return int
     */
    public function getRounds(): int
    {
        return $this->rounds;
    }
    
    /**
     * Sets the number of rounds left
     * @param int $rounds
     */
    public function setRounds(int $rounds)
    {
        $this->rounds = $rounds;
    }
    
    /**
     * Decreases the number of rounds left
     * @param int $roundsToDecrease
     */
    public function decreaseRounds(int $roundsToDecrease = 1)
    {
        if ($this->rounds < $roundsToDecrease) {
            throw new ArgumentException('The number of rounds that are subtracted cannot be bigger than the number if rounds left for this buff.');
        }
        
        $this->rounds -= $roundsToDecrease;
    }
    
    /**
     * Returns the amount of health the badguy gets healed
     * @return int
     */
    public function getBadguyRegeneration(): int
    {
        return $this->badguyRegeneration;
    }
    
    /**
     * Returns the number of health the goodguy gets healed
     * @return int
     */
    public function getGoodguyRegeneration(): int
    {
        return $this->goodguyRegeneration;
    }
    
    /**
     * Returns the fraction of life that gets absorbed from the damage applied to the badguy
     * @return float
     */
    public function getBadguyLifetap(): float
    {
        return $this->badguyLifetap;
    }
    
    /**
     * Returns the fraction of life that gets absorbed from the damage applied to the goodguy
     * @return float
     */
    public function getGoodguyLifetap(): float
    {
        return $this->goodguyLifetap;
    }

    /**
     * Returns the fraction of the damage applied to the badguy that gets reflected to the goodguy
     * @return float
     */
    public function getBadguyDamageReflection(): float
    {
        return $this->badguyDamageReflection;
    }
    
    /**
     * Returns the fraction of the damage applied to the goodguy that gets reflected to the badguy
     * @return float
     */
    public function getGoodguyDamageReflection(): float
    {
        return $this->goodguyDamageReflection;
    }
    
    /**
     * Returns the number of minions
     * @return int
     */
    public function getNumberOfMinions(): int
    {
        return $this->numberOfMinions;
    }
    
    /**
     * Returns the minium damage a minion afflicts to the badguy
     * @return int
     */
    public function getMinionMinBadguyDamage(): int
    {
        return $this->minionMinBadguyDamage;
    }
    
    /**
     * Returns the maximum damage a minion afflicts to the goodguy
     * @return int
     */
    public function getMinionMaxGoodguyDamage(): int
    {
        return $this->minionMaxGoodguyDamage;
    }
    
    /**
     * Returns the minium damage a minion afflicts to the goodguy
     * @return int
     */
    public function getMinionMinGoodguyDamage(): int
    {
        return $this->minionMinGoodguyDamage;
    }
    
    /**
     * Returns the maximum damage a minion afflicts to the badguy
     * @return int
     */
    public function getMinionMaxBadguyDamage(): int
    {
        return $this->minionMaxBadguyDamage;
    }
    
    /**
     * Returns a factor which modifies the damage applied TO the badguy
     * @return float
     */
    public function getBadguyDamageModifier(): float
    {
        return $this->badguyDamageModifier;
    }
    
    /**
     * Returns a factor which modifies the badguy's attack value
     * @return float
     */
    public function getBadguyAttackModifier(): float
    {
        return $this->badguyAttackModifier;
    }
    
    /**
     * Returns a factor which modified the badguy's defense value
     * @return float
     */
    public function getBadguyDefenseModifier(): float
    {
        return $this->badguyDefenseModifier;
    }
    
    /**
     * Returns true if the badguy is invulnurable
     * @return bool
     */
    public function badguyIsInvulnurable(): bool
    {
        return $this->badguyInvulnurable;
    }
    
    /**
     * Returns a factor which modifies the damage applied TO the goodguy
     * @return float
     */
    public function getGoodguyDamageModifier(): float
    {
        return $this->goodguyDamageModifier;
    }
    
    /**
     * Returns a factor which modifies the goodguy's attack value
     * @return float
     */
    public function getGoodguyAttackModifier(): float
    {
        return $this->goodguyAttackModifier;
    }
    
    /**
     * Returns a factor which modified the goodguy's defense value
     * @return float
     */
    public function getGoodguyDefenseModifier(): float
    {
        return $this->goodguyDefenseModifier;
    }
    
    /**
     * Returns true if the goodguy is invulnurable
     * @return bool
     */
    public function getGoodguyIsInvulnurable(): bool
    {
        return $this->goodguyInvulnurable;
    }
}
