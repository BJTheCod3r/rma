<?php

namespace App\Models\RMA;

use App\Models\RMA\Type\BaseIdentifiableEnum;
use App\Models\RMA\Type\RMA_TYPE;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RMAItem extends Model
{
    use HasFactory;

    protected $table = 'rma_items';

    protected $casts = [
        'type' => RMA_TYPE::class
    ];

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @param RMA $rma
     * @param RMAItemData $data
     * @return static
     */
    public static function createFromData(RMA $rma, RMAItemData $data): static
    {
        return $rma->items()->create($data->toArray());
    }

    /**
     * @return BelongsTo
     */
    public function rma(): BelongsTo
    {
        return $this->belongsTo(RMA::class);
    }

    /**
     * @return BaseIdentifiableEnum
     */
    public function getValue(): BaseIdentifiableEnum
    {
        return $this->type->getAssociatedEnumInstance($this->value);
    }
}
